<?php

//use SimpleSAML;
//require_once('/home/project/simplesamlphp/simplesamlphp/lib/_autoload.php');
//use SAML2\Utilities;

use SimpleSAML\Utils\XML;
//use SimpleSAML\Metadata\SAMLParser;

use SimpleSAML\Metadata\SAMLParser;

//use SimpleSAML\Utilities;

/* -*- coding: utf-8 -*-
 * Copyright 2015 Okta, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * metadata_url_for contains PER APPLICATION configuration settings.
 * Each SAML service that you support will have different values here.
 *
 * NOTE:
 *   This is implemented as an array for DEMONSTRATION PURPOSES ONLY.
 *   On a production system, this information should be stored as approprate
 *   With each key below mapping to your concept of "customer company",
 *   "group", "organization", "team", etc.
 *   This should also be stored in your production datastore.
 */

$metadata_url_for = array(
  /* WARNING WARNING WARNING
     *   You MUST remove the testing IdP (idp.oktadev.com) from a production system,
     *   as the testing IdP will allow ANYBODY to log in as ANY USER!
     * WARNING WARNING WARNING
     * For testing with http://saml.oktadev.com use the line below:
     */
  // 'test' => 'http://idp.oktadev.com/metadata',
  //  'example-okta-com' => 'https://mindfiresolutions-sso.okta.com/app/exkapm6i7B43KLXOS695/sso/saml/metadata',
  // 'example-okta-com' => 'https://dev-10154300.okta.com/app/exk18suxwtWdHm5v05d7/sso/saml/metadata',
  // 'example-stafford-com' => 'https://sso.stafford.va.us/sso/saml/metadata',
  'example-stafford-com' => 'https://sso.stafford.va.us/federationmetadata/2007-06/FederationMetadata.xml',
);

foreach ($metadata_url_for as $idp_name => $metadata_url) {
  /*
   * Fetch SAML metadata from the URL.
   * NOTE:
   *  SAML metadata changes very rarely. On a production system,
   *  this data should be cached as approprate for your production system.
   */
  $metadata_xml = file_get_contents($metadata_url);

  //  $xmlObj = new \SimpleSAML\Utils\XML();

  /*
   * Parse the SAML metadata using SimpleSAMLphp's parser.
   * See also: modules/metaedit/www/edit.php:34
   */
  //  SimpleSAML_Utilities::validateXMLDocument($metadata_xml, 'saml-meta');
  //    \SimpleSAML\Utils\XML::checkSAMLMessage($metadata_xml, 'saml-meta');
  //    $xmlObj->checkSAMLMessage($metadata_xml, 'saml-meta');

  (new XML())->checkSAMLMessage($metadata_xml, 'saml-meta');

  //    SimpleSAML\Utils\XML::checkSAMLMessage($metadata_xml, 'saml-meta');
  // SimpleSAML\Utilities::validateXMLDocument($metadata_xml, 'saml-meta');
  // $entities = SimpleSAML_Metadata_SAMLParser::parseDescriptorsString($metadata_xml);
  //   $entities = \SimpleSAML\Metadata\SAMLParser::parseDescriptorsString($metadata_xml);
  //   $entities = (new \SimpleSAML\Metadata\SAMLParser())->parseDescriptorsString($metadata_xml);
  $entities = SAMLParser::parseDescriptorsString($metadata_xml);
  //  $entities = SAMLParser::parseDescriptorsString($metadata_xml);

  //    $smlParser = new SAMLParser();
  //  $entities = $smlParser->parseDescriptorsString($metadata_xml);
  $entity = array_pop($entities);
  $idp = $entity->getMetadata20IdP();
  $entity_id = $idp['entityid'];
  //  var_dump($idp);

  /*
   * Remove HTTP-POST endpoints from metadata,
   * since we only want to make HTTP-GET AuthN requests.
   */
  for ($x = 0; $x < sizeof($idp['SingleSignOnService']); $x++) {
    $endpoint = $idp['SingleSignOnService'][$x];
    if ($endpoint['Binding'] == 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST') {
      unset($idp['SingleSignOnService'][$x]);
    }
  }

  /*
   * Don't sign AuthN requests.
   */
  if (isset($idp['sign.authnrequest'])) {
    unset($idp['sign.authnrequest']);
  }

  /*
   * Set up the "$config" and "$metadata" variables as used by SimpleSAMLphp.
   */
  $config[$idp_name] = array(
    'saml:SP',
    'entityID' => null,
    'idp' => $entity_id,
    // NOTE: This is how you configure RelayState on the server side.
    // 'RelayState' => "",
  );

  $metadata[$entity_id] = $idp;
  // $metadata['https://local.simplesamlphp-oktaa.com/simplesamlphp/www/module.php/saml/sp/metadata.php/example-okta-com'] = array(
  //   // $metadata['http://service.example.com/simplesaml/module.php/saml/sp/metadata.php/default-sp'] = array(
  //   'SingleSignOnService' =>
  //   array(
  //     0 =>
  //     array(
  //       'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
  //       'Location' => 'https://local.simplesamlphp-oktaa.com/simplesamlphp/www/saml2/idp/SSOService.php',
  //       // 'Location' => 'https://local.simplesamlphp-oktaa.com/simplesamlphp/www/module.php/saml/sp/saml2-acs.php/example-okta-com',
  //     ),
  //   ),
  //   'AssertionConsumerService' =>
  //   array(
  //     0 =>
  //     array(
  //       'index' => 0,
  //       'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
  //       // 'Location' => 'http://service.example.com/simplesaml/module.php/saml/sp/saml2-acs.php/default-sp',
  //       'Location' => 'https://local.simplesamlphp-oktaa.com/simplesamlphp/www/module.php/saml/sp/saml2-acs.php/example-okta-com',
  //     ),
  //   ),
  //   'SingleLogoutService' =>
  //   array(
  //     0 =>
  //     array(
  //       'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
  //       'Location' => 'https://local.simplesamlphp-oktaa.com/simplesamlphp/www/module.php/saml/sp/saml2-logout.php/example-okta-com',
  //     ),
  //   ),
  //   // 'certData' => 'MIIDazCCAlOgAwIBAgIJAJ653EqbAryJMA0GCSqGSIb3DQEBCwUAMEwxCzAJBgNVBAYTAlVTMRAwDgYDVQQIDAdORVdZT1JLMQwwCgYDVQQHDANOWUMxDzANBgNVBAoMBlNTTlRQTDEMMAoGA1UECwwDREVWMB4XDTE3MDUwNDEyMjMzOFoXDTI3MDUwNDEyMjMzOFowTDELMAkGA1UEBhMCVVMxEDAOBgNVBAgMB05FV1lPUksxDDAKBgNVBAcMA05ZQzEPMA0GA1UECgwGU1NOVFBMMQwwCgYDVQQLDANERVYwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQC+XfZhpHhuBHLf0UgnUGOv9zP04OMbRgmD/AI/jL4A2GONrOJYdlsCJcU9sAySBFxwZ8UkpkWYzjpzqjRc2ZmSYQmUt9m7raYciynLlcWP5FKdvZjmlTbjL0XGSGtOi4a39A/eYp5JmOx1eZT5jStiFJCUtzEqHfUYO/foGaaGxAqwur2q/8eiaW1PuKjxSRkuGek3i83lWmMAkkxT74YMrpuB2YP2N7wiiIm/ChYI4enYCWQpB8kpSujRzd/OLCL2tNc4Bp8Qhs2mOw46i5arkzzBtIKE0up6wpLsRT+mNpO1lqD9M7EAPi8JZBK7kh/9kJXqaCdXAeJvd18Z+uAZAgMBAAGjUDBOMB0GA1UdDgQWBBTuu/EDcjRd9Mtk3R4IJveBU/mpAjAfBgNVHSMEGDAWgBTuu/EDcjRd9Mtk3R4IJveBU/mpAjAMBgNVHRMEBTADAQH/MA0GCSqGSIb3DQEBCwUAA4IBAQAy20lxkQ9lR2wzUsH7jfYJNXJ2/Qc34YHguGDuxzMGzAPVu6CHUygUlaUBW/QTCam/xvru/pqsKAzs0FYiuImJr/X6wbJpDZNcvd/27ZuXbGK7N0k/F446KA9VOh8F7eRa0S3+WqU1MpnBxIvYT0D0xsSKDBKhx/giLaQMJv73PHFC+UXFmUnd/U4fcJc4gUJC2vAjr43DJjvQxJC13x9XqjIpaE/57Un2+zIujIvm3ChHu/kdmtwBIXLLehKJO5NqvkqoWJ4n1Mk8lZkRjsXFKCxJInnhRDLvwDj+ruPvpGZrK3VdUfjQQ06EmwCzvXRKetUU02R0k660pr2e6ngk',
  //   'certData' => 'MIIDqDCCApCgAwIBAgIGAXqd129RMA0GCSqGSIb3DQEBCwUAMIGUMQswCQYDVQQGEwJVUzETMBEGA1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEUMBIGA1UECwwLU1NPUHJvdmlkZXIxFTATBgNVBAMMDGRldi0xMDE1NDMwMDEcMBoGCSqGSIb3DQEJARYNaW5mb0Bva3RhLmNvbTAeFw0yMTA3MTMwMzA4MzlaFw0zMTA3MTMwMzA5MzlaMIGUMQswCQYDVQQGEwJVUzETMBEGA1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEUMBIGA1UECwwLU1NPUHJvdmlkZXIxFTATBgNVBAMMDGRldi0xMDE1NDMwMDEcMBoGCSqGSIb3DQEJARYNaW5mb0Bva3RhLmNvbTCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBAK/3tVJXn5iZSW/5kccnTozc9HKDCulbdEQy9nzw+/dIJ4xe0eA9rWpjzW91WLgKL+OIKtBLpsKgpGPjCRv/Z7ax7bLaw7swzxmsuUHQZm9N++q4JRqKWhqfmWIJ3r0EyYfVcZaE1ooHsSkZ11eTQEzK4q50WqT7JCF6Upm5MeXFzKXR+DgbGF2aAg+mT/orqs8TXRk8VWSc/W+4kWkkBDAizbJlhKB/+jJgSIxgI52hytySPYbiKKIkg9LY4bZyO/vtnUjuYaUqCLlAhQdO4sqfvfOmPFeY1XTXx9+Fvn5u2xIVq9ure/EMEy99fvhnbQQMt+Bc+FEg29cEn8wUsOkCAwEAATANBgkqhkiG9w0BAQsFAAOCAQEASp78Zyd9Wa/ZopZKNjxC04nH2BOQHnzHzy6/JFwlC4U1KD1uoMq99D7BpXFVTKOM2WjY893AKcUOpgYo3adoFQ/EHjEKSPxpekPu5hZCYBQmZ+zBxPiHPGnDhOMOryXcWB4m41g4NcaHRG+5dAyODauACg0KjzQefLE/dvW8Z8yuxGzvWSv6G8gORvetSOSIxz7jiwtkYthXni9dpOoHXowS6J/qrtE2FxUSJ5JaaVqzqoKE7TGaSnlljV2uDZ61+2Ie34i4YO037sBJqSJ0LQo3MDXbd6nZgTUUrjOQLYXKwRKtkZ6JhkyXh11p5zRo2iK74F0bNN2lDmcNGHemgA==',
  // );

  $metadata['https://local.simplesamlphp-oktaa.com/simplesamlphp/www/module.php/saml/sp/metadata.php/example-stafford-com'] = array(
    // $metadata['http://service.example.com/simplesaml/module.php/saml/sp/metadata.php/default-sp'] = array(
    'SingleSignOnService' =>
    array(
      0 =>
      array(
        'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        'Location' => 'https://local.simplesamlphp-oktaa.com/simplesamlphp/www/saml2/idp/SSOService.php',
        // 'Location' => 'https://local.simplesamlphp-oktaa.com/simplesamlphp/www/module.php/saml/sp/saml2-acs.php/example-okta-com',
      ),
    ),
    'AssertionConsumerService' =>
    array(
      0 =>
      array(
        'index' => 0,
        'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
        // 'Location' => 'http://service.example.com/simplesaml/module.php/saml/sp/saml2-acs.php/default-sp',
        'Location' => 'https://local.simplesamlphp-oktaa.com/simplesamlphp/www/module.php/saml/sp/saml2-acs.php/example-stafford-com',
      ),
    ),
    'SingleLogoutService' =>
    array(
      0 =>
      array(
        'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        'Location' => 'https://local.simplesamlphp-oktaa.com/simplesamlphp/www/module.php/saml/sp/saml2-logout.php/example-stafford-com',
      ),
    ),
    // 'certData' => 'MIIDazCCAlOgAwIBAgIJAJ653EqbAryJMA0GCSqGSIb3DQEBCwUAMEwxCzAJBgNVBAYTAlVTMRAwDgYDVQQIDAdORVdZT1JLMQwwCgYDVQQHDANOWUMxDzANBgNVBAoMBlNTTlRQTDEMMAoGA1UECwwDREVWMB4XDTE3MDUwNDEyMjMzOFoXDTI3MDUwNDEyMjMzOFowTDELMAkGA1UEBhMCVVMxEDAOBgNVBAgMB05FV1lPUksxDDAKBgNVBAcMA05ZQzEPMA0GA1UECgwGU1NOVFBMMQwwCgYDVQQLDANERVYwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQC+XfZhpHhuBHLf0UgnUGOv9zP04OMbRgmD/AI/jL4A2GONrOJYdlsCJcU9sAySBFxwZ8UkpkWYzjpzqjRc2ZmSYQmUt9m7raYciynLlcWP5FKdvZjmlTbjL0XGSGtOi4a39A/eYp5JmOx1eZT5jStiFJCUtzEqHfUYO/foGaaGxAqwur2q/8eiaW1PuKjxSRkuGek3i83lWmMAkkxT74YMrpuB2YP2N7wiiIm/ChYI4enYCWQpB8kpSujRzd/OLCL2tNc4Bp8Qhs2mOw46i5arkzzBtIKE0up6wpLsRT+mNpO1lqD9M7EAPi8JZBK7kh/9kJXqaCdXAeJvd18Z+uAZAgMBAAGjUDBOMB0GA1UdDgQWBBTuu/EDcjRd9Mtk3R4IJveBU/mpAjAfBgNVHSMEGDAWgBTuu/EDcjRd9Mtk3R4IJveBU/mpAjAMBgNVHRMEBTADAQH/MA0GCSqGSIb3DQEBCwUAA4IBAQAy20lxkQ9lR2wzUsH7jfYJNXJ2/Qc34YHguGDuxzMGzAPVu6CHUygUlaUBW/QTCam/xvru/pqsKAzs0FYiuImJr/X6wbJpDZNcvd/27ZuXbGK7N0k/F446KA9VOh8F7eRa0S3+WqU1MpnBxIvYT0D0xsSKDBKhx/giLaQMJv73PHFC+UXFmUnd/U4fcJc4gUJC2vAjr43DJjvQxJC13x9XqjIpaE/57Un2+zIujIvm3ChHu/kdmtwBIXLLehKJO5NqvkqoWJ4n1Mk8lZkRjsXFKCxJInnhRDLvwDj+ruPvpGZrK3VdUfjQQ06EmwCzvXRKetUU02R0k660pr2e6ngk',
    'certData' => 'MIIDqDCCApCgAwIBAgIGAXqd129RMA0GCSqGSIb3DQEBCwUAMIGUMQswCQYDVQQGEwJVUzETMBEGA1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEUMBIGA1UECwwLU1NPUHJvdmlkZXIxFTATBgNVBAMMDGRldi0xMDE1NDMwMDEcMBoGCSqGSIb3DQEJARYNaW5mb0Bva3RhLmNvbTAeFw0yMTA3MTMwMzA4MzlaFw0zMTA3MTMwMzA5MzlaMIGUMQswCQYDVQQGEwJVUzETMBEGA1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEUMBIGA1UECwwLU1NPUHJvdmlkZXIxFTATBgNVBAMMDGRldi0xMDE1NDMwMDEcMBoGCSqGSIb3DQEJARYNaW5mb0Bva3RhLmNvbTCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBAK/3tVJXn5iZSW/5kccnTozc9HKDCulbdEQy9nzw+/dIJ4xe0eA9rWpjzW91WLgKL+OIKtBLpsKgpGPjCRv/Z7ax7bLaw7swzxmsuUHQZm9N++q4JRqKWhqfmWIJ3r0EyYfVcZaE1ooHsSkZ11eTQEzK4q50WqT7JCF6Upm5MeXFzKXR+DgbGF2aAg+mT/orqs8TXRk8VWSc/W+4kWkkBDAizbJlhKB/+jJgSIxgI52hytySPYbiKKIkg9LY4bZyO/vtnUjuYaUqCLlAhQdO4sqfvfOmPFeY1XTXx9+Fvn5u2xIVq9ure/EMEy99fvhnbQQMt+Bc+FEg29cEn8wUsOkCAwEAATANBgkqhkiG9w0BAQsFAAOCAQEASp78Zyd9Wa/ZopZKNjxC04nH2BOQHnzHzy6/JFwlC4U1KD1uoMq99D7BpXFVTKOM2WjY893AKcUOpgYo3adoFQ/EHjEKSPxpekPu5hZCYBQmZ+zBxPiHPGnDhOMOryXcWB4m41g4NcaHRG+5dAyODauACg0KjzQefLE/dvW8Z8yuxGzvWSv6G8gORvetSOSIxz7jiwtkYthXni9dpOoHXowS6J/qrtE2FxUSJ5JaaVqzqoKE7TGaSnlljV2uDZ61+2Ie34i4YO037sBJqSJ0LQo3MDXbd6nZgTUUrjOQLYXKwRKtkZ6JhkyXh11p5zRo2iK74F0bNN2lDmcNGHemgA==',
  );
}
