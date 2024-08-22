(function () {
    if (typeof window.QSI === 'undefined'){
        window.QSI = {};
    }

    var tempQSIConfig = {"hostedJSLocation":"https://siteintercept.qualtrics.com/dxjsmodule/","baseURL":"https://siteintercept.qualtrics.com","surveyTakingBaseURL":"https://s.qualtrics.com/spoke/all/jam","BrandTier":null,"zoneId":"ZN_2i9VyFIbGal2H6C"};

    // If QSI.config is defined in snippet, merge with QSIConfig from orchestrator-handler.
    if (typeof window.QSI.config !== 'undefined' && typeof window.QSI.config === 'object') {
        // This merges the user defined QSI.config with the handler defined QSIConfig
        // If both objects have a property with the same name,
        // then the second object property overwrites the first.
        for (var attrname in tempQSIConfig) { window.QSI.config[attrname] = tempQSIConfig[attrname]; }
    } else {
        window.QSI.config = tempQSIConfig;
    }

    window.QSI.shouldStripQueryParamsInQLoc = false;
})();

/*@preserve
***Version 2.11.0***
*/

/*@license
 *                       Copyright 2002 - 2018 Qualtrics, LLC.
 *                                All rights reserved.
 *
 * Notice: All code, text, concepts, and other information herein (collectively, the
 * "Materials") are the sole property of Qualtrics, LLC, except to the extent
 * otherwise indicated. The Materials are proprietary to Qualtrics and are protected
 * under all applicable laws, including copyright, patent (as applicable), trade
 * secret, and contract law. Disclosure or reproduction of any Materials is strictly
 * prohibited without the express prior written consent of an authorized signatory
 * of Qualtrics. For disclosure requests, please contact notice@qualtrics.com.
 */

try {
} catch(e) {
  if (typeof QSI !== 'undefined' && QSI.dbg && QSI.dbg.e) {
    QSI.dbg.e(e);
  }
}