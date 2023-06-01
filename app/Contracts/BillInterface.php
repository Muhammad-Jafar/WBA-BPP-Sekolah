<?php

namespace App\Contracts;

interface BillInterface 
{
   public function countProgress(): Float;
   public function countStudentWhoHasBillingsDone(): Int;
   public function countStudentWhoHasBillingsDoneYet(): Int;
   public function results(): array;
}