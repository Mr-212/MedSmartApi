<?php
$xml =
'<?xml version="1.0" encoding="UTF-8"?>
        <MESSAGE xmlns="http://www.mismo.org/residential/2009/schemas" xmlns:p2="http://www.w3.org/1999/xlink" xmlns:p3="inetapi/MISMO3_4_MCL_Extension.xsd" MessageType="Request">
            <ABOUT_VERSIONS>
                <ABOUT_VERSION>
                    <DataVersionIdentifier>201703</DataVersionIdentifier>
                </ABOUT_VERSION>
            </ABOUT_VERSIONS>
            <DEAL_SETS>
                <DEAL_SET>
                    <DEALS>
                    <DEAL>
                        <PARTIES>
                            <PARTY p2:label="Party1">
                                <INDIVIDUAL>
                                <NAME>
                                    <FirstName>'.$this->firstName.'</FirstName>
                                    <LastName>'.$this->lastName.'</LastName>
                                    <MiddleName>'.$this->middleName.'</MiddleName>
                                    <SuffixName>'.$this->nameSuffix.'</SuffixName>
                                </NAME>
                                </INDIVIDUAL>
                                <ROLES>
                                <ROLE>
                                    <BORROWER>
                                        <RESIDENCES>
                                            <RESIDENCE>
                                            <ADDRESS>
                                                <AddressLineText>'.$this->addressLine.'</AddressLineText>
                                                <CityName>'.$this->city.'</CityName>
                                                <CountryCode>'.$this->countryCode.'</CountryCode>
                                                <PostalCode>'.$this->postalCode.'</PostalCode>
                                                <StateCode>'.$this->stateCode.'</StateCode>
                                            </ADDRESS>
                                            <RESIDENCE_DETAIL>
                                                <BorrowerResidencyType>Current</BorrowerResidencyType>
                                            </RESIDENCE_DETAIL>
                                            </RESIDENCE>
                                        </RESIDENCES>
                                    </BORROWER>
                                    <ROLE_DETAIL>
                                        <PartyRoleType>Borrower</PartyRoleType>
                                    </ROLE_DETAIL>
                                </ROLE>
                                </ROLES>
                                <TAXPAYER_IDENTIFIERS>
                                <TAXPAYER_IDENTIFIER>
                                    <TaxpayerIdentifierType>SocialSecurityNumber</TaxpayerIdentifierType>
                                    <TaxpayerIdentifierValue>'.$this->socialSecurityNumber.'</TaxpayerIdentifierValue>
                                </TAXPAYER_IDENTIFIER>
                                </TAXPAYER_IDENTIFIERS>
                            </PARTY>
                        </PARTIES>
                        <RELATIONSHIPS>
                            <!--  Link borrower to the service  -->
                            <RELATIONSHIP p2:arcrole="urn:fdc:Meridianlink.com:2017:mortgage/PARTY_IsVerifiedBy_SERVICE" p2:from="Party1" p2:to="Service1" />
                        </RELATIONSHIPS>
                        <SERVICES>
                            <SERVICE p2:label="Service1">
                                <CREDIT>
                                <CREDIT_REQUEST>
                                    <CREDIT_REQUEST_DATAS>
                                        <CREDIT_REQUEST_DATA>
                                            <CREDIT_REPOSITORY_INCLUDED>'
                                            .$this->getCreditRepositoryBlock().
                                            '</CREDIT_REPOSITORY_INCLUDED>
                                            <CREDIT_REQUEST_DATA_DETAIL>
                                            <CreditReportRequestActionType>Submit</CreditReportRequestActionType>
                                            </CREDIT_REQUEST_DATA_DETAIL>
                                        </CREDIT_REQUEST_DATA>
                                    </CREDIT_REQUEST_DATAS>
                                </CREDIT_REQUEST>
                                </CREDIT>
                                <SERVICE_PRODUCT>
                                <SERVICE_PRODUCT_REQUEST>
                                    <SERVICE_PRODUCT_DETAIL>
                                        <ServiceProductDescription>CreditOrder</ServiceProductDescription>
                                        <EXTENSION>
                                            <OTHER>
                                            <!--  Recommend requesting only the formats you need, to minimize processing time  -->
                                            <p3:SERVICE_PREFERRED_RESPONSE_FORMATS>'
                                                .$this->getPrefferedServiceFormatBlock().
                                            '</p3:SERVICE_PREFERRED_RESPONSE_FORMATS>
                                            </OTHER>
                                        </EXTENSION>
                                    </SERVICE_PRODUCT_DETAIL>
                                </SERVICE_PRODUCT_REQUEST>
                                </SERVICE_PRODUCT>
                            </SERVICE>
                        </SERVICES>
                    </DEAL>
                    </DEALS>
                </DEAL_SET>
            </DEAL_SETS>
        </MESSAGE>';

    return $xml;


    