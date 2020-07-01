<?php

/**
 * ユーザー
 */

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\MasterDataRepository;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserService
{
    private $userRepository;
    private $masterDataRepository;

    public function __construct(
        UserRepository $userRepository,
        MasterDataRepository $masterDataRepository
    ) {
        $this->userRepository = $userRepository;
        $this->masterDataRepository = $masterDataRepository;
    }

    /**
     * Insert user data
     *
     * @param int $user_id
     * @return array
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
     * @return string
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
     * Confirm the passed token is the one initially assigned to the user
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
     * Confirm the passed token is the one initially assigned to the user
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
