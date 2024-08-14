<?php

namespace App\Interfaces;

interface MemberRepositoryInterface 
{
    public function getMemberById(int $memberId);
    public function createMember(array $memberData);
    public function updateMember(int $memberId, array $newMemberData);
}