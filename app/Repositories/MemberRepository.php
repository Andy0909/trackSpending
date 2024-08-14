<?php

namespace App\Repositories;

use App\Interfaces\MemberRepositoryInterface;
use App\Models\Member;

class MemberRepository implements MemberRepositoryInterface 
{
    /** @var Member */
    private $memberModel;

    /**
     * construct
     * @param Member $memberModel
     */
    public function __construct(Member $memberModel) 
    {
        $this->memberModel = $memberModel;
    }

    /**
     * 利用 id 取得 member 資料
     * @param int $memberId
     * @return Member
     */
    public function getMemberById(int $memberId): Member
    {
        return $this->memberModel->findOrFail($memberId);
    }

    /**
     * 利用 id 取得 member 資料
     * @param int $memberId
     * @return Member
     */
    public function createMember(array $memberData) 
    {
        return $this->memberModel->create($memberData);
    }

    public function updateMember(int $memberId, array $newMemberData) 
    {
        return $this->memberModel->whereId($memberId)->update($newMemberData);
    }
}