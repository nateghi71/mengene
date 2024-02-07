<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rent_contract', function (Blueprint $table) {
            $table->id();
            $table->string('landlordName');
            $table->string('landlordFather');
            $table->string('landlordCertificateNumber');
            $table->string('landlordCertificateIssuedBy');
            $table->string('landlordCertificateNationalCode');
            $table->string('landlordBornAt');
            $table->string('landlordResidentAt');
            $table->string('landlordPhoneNumber');
            $table->string('byLandlordAdvocacyName');
            $table->string('landlordAdvocacyFather');
            $table->string('landlordAdvocacyCertificateNumber');
            $table->string('landlordAdvocacyBornAt');
            $table->string('landlordAdvocacyBornAt');
            $table->string('landlordAdvocacyForReason');

            $table->string('renterName');
            $table->string('renterFather');
            $table->string('renterCertificateNumber');
            $table->string('renterCertificateIssuedBy');
            $table->string('renterCertificateNationalCode');
            $table->string('renterBornAt');
            $table->string('renterResidentAt');
            $table->string('renterPhoneNumber');
            $table->string('byRenterAdvocacyName');
            $table->string('renterAdvocacyFather');
            $table->string('renterAdvocacyCertificateNumber');
            $table->string('renterAdvocacyBornAt');
            $table->string('renterAdvocacyBornAt');
            $table->string('renterAdvocacyForReason');

            $table->string('tamlikManafeh');
            $table->string('estateDong');
            $table->string('estateAddress');
            $table->string('estatePlaque');
            $table->string('estateSubsidiaryOf');
            $table->string('estateMainOf');
            $table->string('estatePart');
            $table->string('estateArea');
            $table->string('officeSerialNumber');
            $table->string('inPage');
            $table->string('inOffice');
            $table->string('OfficeAuthor');
            $table->string('numberOfRooms');
            $table->string('numberOfSubsidiary');
            $table->string('subsidiaryScale');
            $table->string('numberOfStoreSubsidiary');
            $table->string('storeSubsidiaryScale');
            $table->string('estatePhoneNumber');

            $table->string('rentTime');
            $table->string('rentDateFrom');
            $table->string('rentDateTo');

            $table->string('totalRent');
            $table->string('monthRent');
            $table->string('landlordCartNumber');
            $table->string('landlordCartOwner');
            $table->string('bankName');
            $table->string('numberOfCheck');
            $table->string('idsCheck');
            $table->string('checkForBank');

            $table->string('rahnAmountPayed');
            $table->string('rahnIdCheckPayed');
            $table->string('rahnBankNamePayed');
            $table->string('rahnBranchBankPayed');
            $table->string('rahnIdCheckPay');
            $table->string('rahnBankNamePay');
            $table->string('rahnBranchBankPay');
            $table->string('rahnDatePay');
            $table->string('estateYieldDate');
            $table->string('commercialPayNumber');
            $table->string('commercialPayLetters');
            $table->string('payDayAfterExpire');
            $table->string('numberOfDocument');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rent_contract');
    }
};
