<?php

namespace Chekonline\Cashbox;


class PayAttribute
{
	const FULL_PAYMENT_BEFORE = 1;
	const PART_PAYMENT_BEFORE = 2;
	const PREPAID_EXPENSE = 3;
	const FULL_PAYMENT = 4;
	const PART_PAYMENT = 5;
	const WITHOUT_PAYMENT = 6;
	const CREDIT_PAYMENT = 7;
}