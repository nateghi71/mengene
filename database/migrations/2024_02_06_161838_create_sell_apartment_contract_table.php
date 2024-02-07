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
        Schema::create('sell_apartment_contract', function (Blueprint $table) {
            $table->id();
            $table->string('sellerName');
            $table->string('sellerFather');
            $table->string('sellerCertificateNumber');
            $table->string('sellerCertificateIssuedBy');
            $table->string('sellerCertificateNationalCode');
            $table->string('sellerBornAt');
            $table->string('sellerResidentAt');
            $table->string('sellerPhoneNumber');
            $table->string('bySellerAdvocacyName');
            $table->string('sellerAdvocacyFather');
            $table->string('sellerAdvocacyCertificateNumber');
            $table->string('sellerAdvocacyBornAt');
            $table->string('sellerAdvocacyBornAt');
            $table->string('sellerAdvocacyForReason');

            $table->string('buyerName');
            $table->string('buyerFather');
            $table->string('buyerCertificateNumber');
            $table->string('buyerCertificateIssuedBy');
            $table->string('buyerCertificateNationalCode');
            $table->string('buyerBornAt');
            $table->string('buyerResidentAt');
            $table->string('buyerPhoneNumber');
            $table->string('byBuyerAdvocacyName');
            $table->string('buyerAdvocacyFather');
            $table->string('buyerAdvocacyCertificateNumber');
            $table->string('buyerAdvocacyBornAt');
            $table->string('buyerAdvocacyBornAt');
            $table->string('buyerAdvocacyForReason');

            $table->string('estateNumberOfDongs');
            $table->string('estateAddress');

            $table->string('estatePlaque');
            $table->string('estateSubsidiaryOf');
            $table->string('estateMainOf');
            $table->string('numberOfRooms');
            $table->string('numberOfFloor');
            $table->string('numberOfUnite');
            $table->string('documentId');
            $table->string('waterId');
            $table->string('gasId');
            $table->string('estatePhoneNumber');
            $table->string('estateStoreArea');
            $table->string('estateStoreNumber');
            $table->string('estateParkingIds');
            $table->string('estateNumberEndWork');
            $table->string('estateDateEndWork');
            $table->string('estateIssuedByMunicipality');

            $table->string('estateَAmountRialsByNumber');
            $table->string('estateَAmountRialsByLetters');
            $table->string('estateَAmountTomanByLetters');

            $table->string('estateAmountPayed');
            $table->string('estateIdCheckPayed');
            $table->string('estateBankNamePayed');
            $table->string('estateBranchBankPayed');
            $table->string('estateIdCheckPay');
            $table->string('estateBankNamePay');
            $table->string('estateBranchBankPay');
            $table->string('estateDatePay');
            $table->string('SetUpTheDocumentTime');
            $table->string('SetUpTheDocumentDate');
            $table->string('SetUpTheDocumentAtOfficialNumber');
            $table->string('SetUpTheDocumentAddress');
            $table->string('OfficialPresentedByBank');
            $table->string('SetUpTheDocumentAbsencePayPenalty');

            $table->string('estateYieldDate');
            $table->string('estateYieldDayPayPenalty');
            $table->string('estateNotReadyPayPenalty');

            $table->string('numberOfDocument');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sell_apartment_contract');
    }
};
