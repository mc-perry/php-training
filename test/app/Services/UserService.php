<?php

/**
 * ユーザー
 */

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\MasterDataRepository;
use App\Repositories\MaintenanceRepository;
use Illuminate\Support\Facades\DB;
use App\Facades\Error;
use Illuminate\Support\Facades\Redis;

class UserService
{
    private $userRepository;
    private $masterDataRepository;
    private $maintenanceRepository;

    public function __construct(
        UserRepository $userRepository,
        MasterDataRepository $masterDataRepository,
        MaintenanceRepository $maintenanceRepository
    ) {
        $this->userRepository = $userRepository;
        $this->masterDataRepository = $masterDataRepository;
        $this->maintenanceRepository = $maintenanceRepository;
    }

    /**
     * Get all users
     *
     * @return Array
     */
    public function getAllUsers()
    {
        return $this->userRepository->getAllUsers();
    }


    /**
     * Get user by id
     *
     * @param int $user_id
     * @return object
     */
    public function getUserByUserID(int $user_id)
    {
        return $this->userRepository->getUserByUserID($user_id);
    }

    /**
     * Get token by user id
     *
     * @param int $user_id
     * @return string
     */
    public function getTokenByUserID(int $user_id)
    {
        return $this->userRepository->getTokenByUserID($user_id);
    }

    /**
     * Get token by user id
     *
     * @param int $user_id
     * @return string
     */
    public function getUserByUserIDAndToken(int $user_id, string $token)
    {
        return $this->userRepository->getUserByUserIDAndToken($user_id, $token);
    }


    /**
     * Insert user data
     *
     * @param array $input
     * @return array
     */
    public function insertUser(array $input)
    {

        $inserted_data = $this->userRepository->insertUser([
            'nickname' => $input['nickname']
        ]);

        return $inserted_data;
    }

    /**
     * Assign the generated token to the user
     *
     * @param int $UserId
     * @return string
     */
    public function assignTokenToUser(int $UserId)
    {
        // Create a token
        $token = random_bytes(8);
        $token = substr(bin2hex($token), 0, 8);
        $userObject = $this->userRepository->getUserByUserID($UserId);
        if ($userObject) {
            $this->userRepository->assignTokenToUser($UserId, $token);
            return $token;
        } else {
            return Error::handleError("100011");
        }
        return null;
    }

    /**
     * Confirm the passed token is the one initially assigned to the user
     *
     * @param int $UserId
     * @param string $TokenToCheck
     * @return bool
     */
    public function checkForCorrectToken(int $UserId, string $TokenToCheck)
    {
        $userObject = $this->userRepository->getUserByUserID($UserId);
        if ($userObject) {
            $userToken = $userObject['access_token'];
        } else {
            return false;
        }
        if ($TokenToCheck != $userToken) {
            return false;
        }
        // If no errors are thrown the token is correct
        return true;
    }


    /**
     * Confirm the passed token is the one initially assigned to the user
     *
     * @param int $UserId
     * @param string $TokenToCheck
     * @return string
     */
    public function confirmUserToken(int $UserId, string $TokenToCheck)
    {
        $userObject = $this->userRepository->getUserByUserID($UserId);
        if ($userObject) {
            $userToken = $userObject['access_token'];
            if (!$userToken) {
                Error::handleError("100011");
            }
        } else {
            return Error::handleError("100011");
        }
        // Wrong token was supplied so it's a 不正アクセス
        if ($TokenToCheck != $userToken) {
            return Error::handleError("100010");
        }
        // If no errors are thrown, return the user object
        return $userObject;
    }

    /**
     * Increment experience and update level in a database transaction
     *
     * @param int $UserId
     * @param int $ExperiencePoints
     * @return object $userObject
     */
    public function incrementExperienceUpdateLevelAndRanking(int $UserId, int $ExperiencePoints)
    {
        $userInfo = $this->getUserByUserID($UserId);
        try {
            // Start the database transaction
            DB::beginTransaction();
            $updatedExp = $this->incrementUserExp($UserId, $ExperiencePoints);
            // Update the level
            $this->updateLevel($UserId, $updatedExp);
            // Set the ranking information in Redis
            Redis::zAdd('ranking', $updatedExp, $userInfo['nickname']);
            // If no error is thrown, commit because the transactions succeeded
            DB::commit();
            // Return the new user object with the passed user
            return $this->getUserByUserID($UserId);
        } catch (Exception $e) {
            Log::debug("Write to the db failed; something bad happened");
            DB::rollBack();
            return Error::handleError("100012");
        }
    }

    /**
     * Function to increment the user experience points
     *
     * @param int $UserId
     * @param int $ExperiencePoints
     * @return int
     */
    public function incrementUserExp(int $UserId, int $ExperiencePoints)
    {
        $exp = $this->userRepository->getCurrentExpByUserId($UserId);
        // Calculate the new total experience value
        $updatedExperienceVal = $exp + $ExperiencePoints;
        // Set the new experience value for the user
        $this->userRepository->setExpForUserById($UserId, $updatedExperienceVal);
        return $updatedExperienceVal;
    }

    /**
     * Function to update the user level given the new experience point value
     *
     * @param int $UserId
     * @param int $ExperiencePoints
     * @return int
     */
    public function updateLevel(int $UserId, int $ExperiencePoints)
    {
        $levelToSet = $this->masterDataRepository->getLevelFromExp($ExperiencePoints)[0];
        $this->userRepository->setLevelForUserById($UserId, $levelToSet);
        return $levelToSet;
    }

    /**
     * Check if a user exists with the given id
     *
     * @param int $UserId
     * @return bool
     */
    public function userExistsWithId(int $UserId)
    {
        $returnObject = $this->getUserByUserID($UserId)->first();
        if ($returnObject) {
            return true;
        } else {
            return false;
        }
    }
}
