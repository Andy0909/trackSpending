<?php

namespace App\Interfaces;

use App\Models\Member;

interface MemberRepositoryInterface 
{
    /**
     * 利用 id 取得 member 資料
     * @param int $memberId
     * @return Member
     */
    public function getMemberById(int $memberId): Member;

    /**
     * 建立 member 資料
     * @param array $memberData
     * @return Member
     */
    public function createMember(array $memberData): Member;
}