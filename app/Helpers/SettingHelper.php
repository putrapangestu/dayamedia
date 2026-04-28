<?php

if (! function_exists('getSetting')) {
    /**
     * Get setting value by key
     *
     * @param  mixed  $default
     * @return mixed
     */
    function getSetting(string $key, $default = null)
    {
        return \App\Models\Setting::getValue($key, $default);
    }
}

if (! function_exists('getAdminFeeTransaction')) {
    /**
     * Get admin fee for transaction (nominal Rp)
     *
     * @return int
     */
    function getAdminFeeTransaction()
    {
        return (int) getSetting('transaction_fee', 2000);
    }
}

if (! function_exists('getAdminFeeWithdrawal')) {
    /**
     * Get admin fee for withdrawal (nominal Rp)
     *
     * @return int
     */
    function getAdminFeeWithdrawal()
    {
        return (int) getSetting('withdrawal_fee', 5000);
    }
}

if (! function_exists('getMinWithdrawal')) {
    /**
     * Get minimum withdrawal amount
     *
     * @return int
     */
    function getMinWithdrawal()
    {
        return (int) getSetting('min_withdrawal_fee', 50000);
    }
}

if (! function_exists('getTransactionExpiredTime')) {
    /**
     * Get transaction expired time in hours
     *
     * @return int
     */
    function getTransactionExpiredTime()
    {
        return (int) getSetting('expired_time', 24);
    }
}

if (! function_exists('getBankInfo')) {
    /**
     * Get bank information
     *
     * @return array
     */
    function getBankInfo()
    {
        return [
            'bank_info' => getSetting('bank_info', 'BCA'),
            'bank_name' => getSetting('bank_name', 'Bank Central Asia'),
            'bank_account' => getSetting('bank_account', ''),
        ];
    }
}
