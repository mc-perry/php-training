<?php

/**
 * ユーザーテーブル
 */

namespace App\Repositories;

use App\Models\UserModel;

class UserRepository
{
    /**
     * ユーザーIDを指定してデータを取得する
     *
     * @param int $UserId
     * @return object
     */
    public function getUserByUserId(int $UserId)
    {
        return UserModel::query()->where('id', $UserId)->first();
    }

    /**
     * ユーザーIDを指定してデータを取得する
     *
     * @param int $UserId
     * @return User
     */
    public function getTokenByUserId(int $UserId)
    {
        return UserModel::query()->where('id', $UserId)->pluck('access_token')[0];
    }


    /**
     * Get user object with specified id and token
     *
     * @param int $UserId
     * @param string $Token
     * @return User
     */
    public function getUserByUserIDAndToken(int $UserId, string $Token)
    {
        return UserModel::query()->where('id', $UserId)->where('access_token', $Token)->first();
    }


    /**
     * データを挿入する
     *
     * @param array $params
     * @return User
     */

    public function insertUser(array $params)
    {
        return UserModel::create($params);
    }

    /**
     * Assign a token to a user
     *
     * @param array $params
     * @return User
     */
    public function assignTokenToUser(int $UserId, string $token)
    {
        return UserModel::where('id', $UserId)->update(['access_token' => $token]);
    }

    /**
     * Get the exp value for a given user by id
     *
     * @param array $params
     * @return integer containing value of exp for given user if exists
     */
    public function getCurrentExpByUserId(int $UserId)
    {
        return UserModel::select()->where('id', $UserId)->pluck('exp')[0];
    }

    /**
     * Get the exp value for a given user by id
     *
     * @param array $params
     * @return integer containing value of exp for given user if exists
     */
    public function setExpForUserById(int $UserId, int $ExpVal)
    {
        return UserModel::select()->where('id', $UserId)->update(['exp' => $ExpVal]);
    }

    /**
     * Get the exp value for a given user by id
     *
     * @param array $params
     * @return integer containing value of exp for given user if exists
     */
    public function setLevelForUserById(int $UserId, int $LevelVal)
    {
        return UserModel::select()->where('id', $UserId)->update(['level' => $LevelVal]);
    }
}
