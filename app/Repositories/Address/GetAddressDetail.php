<?php

namespace App\Repositories\Address;

Class GetAddressDetail
{

	public function searchAddressDetails($search_address = null){
		try{
			$request_key=config('url.data_tool_request_key');
			$url=config('url.gnaf_search_url');
			$XmlWriter = new \XMLWriter();
			$XmlWriter->openMemory();
	        $XmlWriter->startDocument("1.0", "UTF-8");
	        $XmlWriter->startElement('DtRequest');
	        $XmlWriter->writeAttribute("Method", config('url.data_tool_method_search'));
	        $XmlWriter->writeAttribute("AddressLine",$search_address);
	        $XmlWriter->writeAttribute("ResultLimit", "");
	        $XmlWriter->writeAttribute("RequestId","");
	        $XmlWriter->writeAttribute("RequestKey",$request_key);
	        $XmlWriter->writeAttribute("DepartmentCode", "");
	        $XmlWriter->writeAttribute("OutputFormat", "JSON");
	        $XmlWriter->endElement();
	        $XmlWriter->endDocument();
	        $XmlString = $XmlWriter->outputMemory();
	        $ServerPath = new \SoapClient($url);
	        $KleberRequest = $ServerPath->ProcessXmlRequest(array('DtXmlRequest' => $XmlString));
	        $KleberResultResponse = $KleberRequest->ProcessXmlRequestResult;
	        $dataArray=json_decode($KleberResultResponse);
	        return $dataArray->DtResponse->Result;
	    }catch(\Exception $e){
            return response()->json(['status' => 400, 'message' => $e->getMessage()]);
        }

	}

}
