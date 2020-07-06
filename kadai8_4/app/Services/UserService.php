<?php

/**
 * ユーザー
 */

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\MasterDataRepository;
use App\Repositories\MaintenanceRepository;
use Illuminate\Support\Facades\DB;

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
     * Insert user data
     *
     * @param int $user_id
     * @return object
     */
    public function getUserByUserID(int $user_id)
    {
        $inserted_data = $this->userRepository->getUserByUserID($user_id);
        return $inserted_data;
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
            return "E10500";
        }
        return null;
    }

    /**
     * Confirm the passed token is the one initially assigned to the user
     *
     * @param int $UserId
     * @param string $TokenToCheck
     * @return object
     */
    public function confirmUserToken(int $UserId, string $TokenToCheck)
    {
        $userObject = $this->userRepository->getUserByUserID($UserId);
        if ($userObject) {
            $userToken = $userObject['access_token'];
        } else {
            return "E10500";
        }
        if ($TokenToCheck != $userToken) {
            return "E10510";
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
    public function incrementExperienceAndUpdateLevel(int $UserId, int $ExperiencePoints)
    {
        try {
            // Start the database transaction
            DB::beginTransaction();
            $updatedExp = $this->incrementUserExp($UserId, $ExperiencePoints);
            $this->updateLevel($UserId, $updatedExp);
            // If no error is thrown, commit because both transactions succeeded
            DB::commit();
            // Return the new user object with the passed user
            return $this->getUserByUserID($UserId);
        } catch (Exception $e) {
            Log::debug("something bad happened");
            DB::rollBack();
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
     * Confirm the passed token is the one initially assigned to the user
     *
     * @param int $UserId
     * @return bool
     */
    public function userExistsWithId(int $UserId)
    {
        $levelToSet = $this->masterDataRepository->userExistsWithId($UserId)[0];
        $this->userRepository->setLevelForUserById($UserId, $levelToSet);
        return $levelToSet;
    }
}
