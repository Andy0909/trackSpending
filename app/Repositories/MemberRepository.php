<?php

namespace App\Repositories;

use App\Interfaces\MemberRepositoryInterface;
use App\Models\Member;

class MemberRepository implements MemberRepositoryInterface 
{
    public function getMemberById($memberId) 
    {
        return Member::findOrFail($memberId);
    }

    public function getMemberByEventId($eventId) 
    {
        return Member::findOrFail($eventId);
    }

    public function createMember(array $memberData) 
    {
        return Member::create($memberData);
    }

    public function updateMember($memberId, array $newMemberData) 
    {
        return Member::whereId($memberId)->update($newMemberData);
    }
}