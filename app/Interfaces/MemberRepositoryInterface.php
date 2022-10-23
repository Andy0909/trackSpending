<?php

namespace App\Interfaces;

interface MemberRepositoryInterface 
{
    public function getMemberById($memberId);
    public function getMemberByEventId($eventId);
    public function createMember(array $memberData);
    public function updateMember($memberId, array $newMemberData);
}