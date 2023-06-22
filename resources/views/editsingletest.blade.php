@extends('layout.maintest_template')
@section('content')
<style>
.red {
    color: #FF0000;
} 

.new1{padding-top: 20px;}

.btn-secondary {
  color: #fff;
  background-color: var(--primary-color);
  border-color: var(--primary-color);
}

.btn-secondary3 {
  color: #fff;
  background-color: #aeaeae;
  border-color: #aeaeae;
}

</style>
<div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-3">
            <div class="container-fluid">

                   
                <div class="row g-4">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Edit Single Test</h6>  <h6 style="color: red;">* (Mandatory field)</h6>
                            </div>
<form class="row g-3" id="addsingletestform" name="addsingletestform" method="post" action="{{ url('edit-singletest/'.$singletestlist->id) }}">                            
@csrf
                            <div class="card-body">
                                <div class="row g-4">
                                  
                                 <!-- FORM STARTS HERE -->
  
                                    
                                    <div class="col-sm-3">
                                        <label class="form-label">Test Name<span class="red"> *</span></label>
                                        <input type="text" class="form-control form-control-lg" name="testname" value="{{$singletestlist->testname}}">
                                        <div class="alert-danger pt-1 pb-1 px-1 py-1" id="testnamealert" style="display:none ;">Please enter test name</div>
                                    </div>
                                     <div class="col-sm-3">
                                        <label class="form-label">Test Name in Arabic<span class="red"> *</span></label>
                                        <input type="text" class="form-control form-control-lg" name="testname_ar" value="{{$singletestlist->testnamear}}">
                                        <div class="alert-danger pt-1 pb-1 px-1 py-1" id="testname_aralert" style="display:none ;">Please enter test name in Arabic</div>
                                    </div>
                                    <div class="col-sm-3">
                                                    <label class="form-label">Test Code</label>
                                                    <input type="text" class="form-control form-control-lg" placeholder="Enter here" name="liscode" id="liscode" value="{{$singletestlist->testcode}}">
                                                </div>
                                    
                                     <div class="col-sm-3">
                                    <label class="form-label">Container</label>
                                    <select class="form-select form-select-lg"   name="containers" id="containers">
                                <option value="0">- Please Select -</option>
                                    @foreach ($containers as $contain)
                                <option value="{{$contain->id}}"{{ ( $singletestlist->containers == $contain->id) ? 'selected' : '' }}>{{$contain->container_name}}</option>
                                    @endforeach                                          
                                    </select>
                                    </div>
							
                                    
                                    <div class="col-sm-3">
                                        <label class="form-label">Category<span class="red"> *</span></label>
                                        <select id="testcategory" class="form-select form-select-lg" tabindex="-98" name="testcategory">
                                            <option value="">- Please Select -</option>
                                            @foreach ($testcategory as $testcateg)
                                            <option value="{{$testcateg->id}}" {{ ( $testcateg->id == $singletestlist->testcategory) ? 'selected' : '' }}>{{$testcateg->testcategory}}</option>
                                            @endforeach
                                        </select>                                        
                                        <div class="alert-danger pt-1 pb-1 px-1 py-1" id="categoryalert" style="display:none ;">Please select category</div>
                                        
                                    </div>
                                    
                                    <div class="col-sm-3">
                                        <label class="form-label">Price (Primary)<span class="red"> *</span></label>
                                        
                                        <input type="number" class="form-control form-control-lg" name="primaryprice" id="primaryprice" value="{{$singletestlist->primaryprice}}">
                                        <div class="alert-danger pt-1 pb-1 px-1 py-1" id="primarypricealert" style="display:none ;">Please enter primary price</div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">Price (Secondary) </label>
                                        <input type="number" class="form-control form-control-lg" name="secondaryprice" id="secondaryprice" value="{{$singletestlist->secondaryprice}}" >
                                        <div class="alert-danger pt-1 pb-1 px-1 py-1" id="secondarypricealert" style="display:none ;"></div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">Tax<span class="red"> *</span></label>
                                        <select id="taxname" class="form-select form-select-lg" tabindex="-98" name="taxname">
                                           <option value="">-- Please Select --</option>   
                                            @foreach ($taxes as $tax)
                                            <option value="{{$tax->id}}" {{ ( $tax->id == $singletestlist->tax_id) ? 'selected' : '' }}>{{$tax->taxname}}</option>
                                            @endforeach
                                        </select>                                        
                                        <div class="alert-danger pt-1 pb-1 px-1 py-1" id="taxalert" style="display:none ;">Please select tax</div>
                                        
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">Tax Method<span class="red"> *</span></label>
                                        <select id="tax" class="form-select form-select-lg" name="taxmethod">
                                            <option value="">-- Please Select --</option>                                            
                                            <option value="exclusive" {{ ( $singletestlist->tax_method == 'exclusive') ? 'selected' : '' }}>Exclusive</option>
                                            <option value="inclusive" {{ ( $singletestlist->tax_method == 'inclusive') ? 'selected' : '' }}>Inclusive</option>
                                            
                                        </select>                                        
                                        <div class="alert-danger pt-1 pb-1 px-1 py-1" id="taxmethodalert" style="display:none ;">Please select tax method</div>
                                        
                                    </div>
                                    <div class="col-sm-3">
                                                    <label class="form-label">Volume or Quantity required</label>
                                                    <input type="text" class="form-control form-control-lg" placeholder="Quantity" name="quantity" id="quantity" value="{{$singletestlist->quantity}}" >
                                                </div>
                                      <div class="col-sm-3">
                                        <label class="form-label">Units<span class="red"> *</span></label>
                                        <select id="tax" class="form-select form-select-lg" name="units">
                                        <option value="">-- Please Select --</option>  
                                        
                                            @foreach($labunit as $lab)
                                            <option value="{{$lab->id}}"{{ ( $lab->id == $singletestlist->units) ? 'selected' : '' }}>{{$lab->labunit_name}} </option>
                                              @endforeach
                                            
                                        </select>                                        
                                        <div class="alert-danger pt-1 pb-1 px-1 py-1" id="taxmethodalert" style="display:none ;">Please select Unit</div>
                                        
                                    </div>

                                      <div class="col-sm-3">
                                        <label class="form-label">Tubes<span class="red"> *</span></label>
                                        <select id="tax" class="form-select form-select-lg" name="tubes">
                                            <option value="">-- Please Select --</option>  
                                            @foreach($tube as $tubes)
                                            <option value="{{$tubes->id}}" {{ ( $tubes->id == $singletestlist->tubes) ? 'selected' : '' }}>{{$tubes->tube_name}}</option>
                                              @endforeach
                                            
                                        </select>                                        
                                        <div class="alert-danger pt-1 pb-1 px-1 py-1" id="taxmethodalert" style="display:none ;">Please select Tube</div>
                                        
                                    </div>
                                    <div class="col-sm-3">
                                                    <label class="form-label">Equipment / Machine</label>
                                                    <select name="equipment" class="form-select form-select-lg" id="equipment" placeholder="-- Please Select --">
                                                        <option value="">-- Please Select--</option>
                                                        @foreach ($machines as $equipment)
                                                        <option value="{{ $equipment->machineid }}" {{ ( $equipment->machineid == $singletestlist->equipment) ? 'selected' : '' }}>{{ $equipment->machine_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="form-label">Result Value</label>
                                                    <select class="form-select form-select-lg" name="resultvalue" id="resultvalue">
                                                        <option value="">-- Please Select --</option>
                                                        <option value="alphabets" {{ ( $singletestlist->resultvalue == "alphabets") ? 'selected' : '' }}>Alphabets</option>
                                                        <option value="numbers" {{ ( $singletestlist->resultvalue == "numbers") ? 'selected' : '' }}>Numbers</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="form-label">Duration</label>
                                                    <input type="text" class="form-control form-control-lg" placeholder="expected time required to complete the test" name="duration" id="duration" value="{{$singletestlist->duration}}">
                                                </div>
                                                 
                                    <div class="col-sm-3">
                                                    <label class="form-label">Method</label>
                                                    <select class="form-select form-select-lg" name="parametermethod" id="parametermethod" placeholder="-- Please Select --">
                                                        <option value="">-- Please Select --</option>
                                                        @foreach ($testmethods as $method)
                                                        <option value="{{ $method->testmethodid }}" {{ ( $method->testmethodid == $singletestlist->parameter_method) ? 'selected' : '' }}>{{ $method->testmethod }}</option>
                                                        @endforeach
                                                    </select>
                                                    
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="form-label">Specimen Type</label>
                                                    <select class="form-select form-select-lg" name="samplrtype" id="samplrtype" placeholder="-- Please Select --">
                                                        <option value="">-- Please Select --</option>
                                                        @foreach ($samplrtype as $sampl)
                                                        <option value="{{ $sampl->sampleid }}" {{ ( $sampl->sampleid == $singletestlist->	sample_type) ? 'selected' : '' }}>{{ $sampl->sample_type_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    
                                                </div>
                                                
                                                <div class="form-group">
                                                <label>
                                                    <input type="checkbox" name="test_separately" value="1" {{ $singletestlist->test_separately ? 'checked' : '' }}>
                                                    Is it possible to test separately?
                                                </label>
                                            </div>
                                                <div class="form-group">
                                                    <label for="description">Instructions</label>
                                                    <textarea id="instruction" name="instruction" class="form-control" placeholder="Instructions on the proper collection, handling, and storage of the specimen to ensure accurate test results.Include instructions on the proper storage and handling of the collected specimen. Specify temperature requirements, stability duration, and any precautions to maintain the integrity of the specimen until it reaches the laboratory">{{$singletestlist->test_instruction}}</textarea>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="description">Instructions in Arabic</label>
                                                    <textarea id="instruction_ar" name="instruction_ar" class="form-control" placeholder="Instructions on the proper collection, handling, and storage of the specimen to ensure accurate test results.Include instructions on the proper storage and handling of the collected specimen. Specify temperature requirements, stability duration, and any precautions to maintain the integrity of the specimen until it reaches the laboratory">{{$singletestlist->test_instruction_ar}}</textarea>
                                                
                                                </div>
                                               
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea id="description" name="description" class="form-control" placeholder="A brief description of the test, providing an overview of its purpose, methodology, and clinical significance">{{$singletestlist->test_description}}</textarea>
                                                </div>
                                                
                                                 <div class="form-group">
                                                    <label for="description">Description in Arabic</label>
                                                    <textarea id="description_ar" name="description_ar" class="form-control" placeholder="A brief description of the test, providing an overview of its purpose, methodology, and clinical significance">{{$singletestlist->test_description_ar}}</textarea>
                                                </div>
                                   
                                    
                                    
                                    
                                    <div class="col-lg-12">
                                        <label class="form-label">Normal Range<span class="red"> *</label>
                                        
                                     </div>
                                    @if(!empty($normalrangelist))
                                <table id="Listnormalrange" class="table card-table table-hover align-middle mb-1 mt-0">
                                     <thead>
                                          <tr>
                                          <th colspan="6" class="text-center">Age Limit</th>
                                          <th colspan="9" class="text-center">Normal Value</th>
                                          </tr>
                                            <tr>
                                               <th colspan="3" style="width:100px;" class="text-center">Lower </th>
                                               <th colspan="3" style="width:100px;" class="text-center">Upper</th>
                                               <th colspan="2" style="width:200px;" class="text-center">Male </th>
                                               <th style="width:50px;" class="text-center">Min</th>
                                               <th style="width:50px;" class="text-center">Max</th>
                                               <th colspan="2" style="width:200px;" class="text-center">Female</th>
                                               <th style="width:50px;" class="text-center">Min</th>
                                               <th style="width:50px;" class="text-center">Max</th>
                                               <th style="width:50px;" class="text-center">&nbsp;</th>
                                            </tr>
                                          </thead>
                                    <tbody>
                                        @foreach($normalrangelist as $item)
                                        
                                         <tr>    	
                                            	<th style="width:80px; color: black; text-align: center;">
                                            	    <input type="text" class="form-control form-control-lg" style="padding:5px 7px;" value="{{$item->lowertype}}" name="Listlowertype" id="Listlowertype_{{$item->id}}">
                                                </th>
                                        		<th style="width: 70px; color: black; text-align: center;">
                                                	<input type="text" class="form-control form-control-lg" style="padding:5px 7px;" value="{{$item->agefrom}}" name="Listlowervalue" id="Listlowervalue_{{$item->id}}">
                                                </th>
                                          		<th style="width: 90px;color: black; text-align: center;">
                                               	    <!--<input type="text" class="form-control form-control-lg" style="padding:5px 7px;" value="{{$item->lowerchronological}}" name="Listlowerchronological" id="Listlowerchronological_{{$item->id}}">-->
                                               	    
                            <select class="form-control form-control-lg" style="padding: 5px 7px;" name="Listlowerchronological" id="Listlowerchronological_{{$item->id}}">
                                <option value="Days" {{$item->lowerchronological == 'Days' ? 'selected' : ''}}>Days </option>
                                <option value="Months" {{$item->lowerchronological == 'Months' ? 'selected' : ''}}>Months </option>
                                <option value="Years" {{$item->lowerchronological == 'Years' ? 'selected' : ''}}>Years </option>
                            </select>
                                                </th>
        
                                          		<th style="width: 80px; color: black; text-align: center;">
                                                     <input type="text" class="form-control form-control-lg" style="padding:5px 7px;" value="{{$item->highertype}}" name="Listhighertype" id="Listhighertype_{{$item->id}}">
                                                </th>
                                        		<th style="width: 70px; color: black; text-align: center;">
                                                <input type="text" class="form-control form-control-lg" style="padding:5px 7px;" value="{{$item->ageto}}"  name="Listhighervalue" id="Listhighervalue_{{$item->id}}">
                                                </th>
                                          		<th style="width: 90px; color: black; text-align: center;">
                                                    <!--<input type="text" class="form-control form-control-lg" style="padding:5px 7px;" value="{{$item->higherchronological}}" name="Listlhigherchronological" id="Listlhigherchronological_{{$item->id}}">-->
                                                      <select class="form-control form-control-lg" style="padding: 5px 7px;" name="Listlhigherchronological" id="Listlhigherchronological_{{$item->id}}">
                                <option value="Days" {{$item->higherchronological == 'Days' ? 'selected' : ''}}>Days</option>
                                <option value="Months" {{$item->higherchronological == 'Months' ? 'selected' : ''}}>Months</option>
                                <option value="Years" {{$item->higherchronological == 'Years' ? 'selected' : ''}}>Years</option>
                    </select>
                                           
                                                
                                                </th>
                                                
                                                <th colspan="2" style="width:100px; color: black; text-align: center;">
                                                <input type="text" class="form-control form-control-lg" style="padding:5px 7px;"  value="{{$item->malerange}}" name="Listmalevalue" id="Listmalevalue_{{$item->id}}"></th>
                                        		<th style="width: 80px; color: black; text-align: center;">
                                                <input type="text" class="form-control form-control-lg" style="padding:5px 7px;" value="{{$item->minmalevalue}}" name="Listminmalevalue" id="Listminmalevalue_{{$item->id}}"></th>
                                                <th style="width: 80px; color: black; text-align: center;">
                                                <input type="text" class="form-control form-control-lg" style="padding:5px 7px;" value="{{$item->maxmalevalue}}" name="Listmaxmalevalue" id="Listmaxmalevalue_{{$item->id}}">
                                                </th>
                                                
                                          		<th colspan="2" style="width: 100px; color: black; text-align: center;">
                                                <input type="text" class="form-control form-control-lg" style="padding:5px 7px;" value="{{$item->femalerange}}" name="Listfemalevalue" id="Listfemalevalue_{{$item->id}}"></th>
                                                <th style="width: 80px; color: black; text-align: center;">
                                                <input type="text" class="form-control form-control-lg" style="padding:5px 7px;" value="{{$item->minfemalevalue}}" name="Listminfemalevalue" id="Listminfemalevalue_{{$item->id}}"></th>
                                                <th style="width: 80px; color: black; text-align: center;">
                                                <input type="text" class="form-control form-control-lg" style="padding:5px 7px;" value="{{$item->maxfemalevalue}}" name="Listmaxfemalevalue" id="Listmaxfemalevalue_{{$item->id}}"></th>
                                                <th style="width:100px; color: black; text-align: center; padding-bottom:15px;"><a onclick="normalRangeSaveValidation({{$item->id}});" class="btn-sm btn-info" style="text-transform:capitalize; font-weight:600; cursor:pointer;">Update</a></th>
                                          		
                                            </tr>
                                        
                                        @endforeach
                                        
                                    </tbody>
                                    </table>
                                    @endif


      <table id="normalrange" class="table card-table table-hover align-middle mb-1 mt-0" style="width: 100%; display:none" >
                                    <thead>
                                        <tr>
                                           <th style="width:270px;">#</th>
                                            <th style="width:270px;">Age</th>
                                            <th style="width:270px;">General</th>
                                            <th style="width:270px;">Male</th>
                                            <th style="width:270px;">Female</th>
                                            <!--<th>Actions</th>                                           
                                            -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        
                                    </tbody>
                                    </table>



            <div class="card-body"> 
                                              <div class="col-sm-12">
                                              	<div class="row"> 
<table class="table table-bordered" style="margin-bottom:0px;">
  <thead>
  <tr>
  <th colspan="6" class="text-center">Age Limit</th>
  <th colspan="9" class="text-center">Normal Value</th>
  
  
  </tr>
    <tr>
       <th colspan="3" style="width:100px;" class="text-center">Lower </th>
       <th colspan="3" style="width:100px;" class="text-center">Upper</th>
       <th colspan="2" style="width:200px;" class="text-center">Male </th>
       <th style="width:50px;" class="text-center">Min</th>
       <th style="width:50px;" class="text-center">Max</th>
       <th colspan="2" style="width:200px;" class="text-center">Female</th>
       <th style="width:50px;" class="text-center">Min</th>
       <th style="width:50px;" class="text-center">Max</th>
       <th style="width:50px;" class="text-center">&nbsp;</th>
    </tr>
    <tr>    	
    	<th style="width:80px; background-color: #daeef3;color: black; text-align: center;">
        <select style="padding:5px 2px;" class="form-select form-select-lg" name="lowertype" id="lowertype">
            <option value=">="> >= </option>
        </select>
        </th>
		<th style="width: 70px; background-color: #daeef3;color: black; text-align: center;">
        	<input type="text" class="form-control form-control-lg" style="padding:5px 7px;" name="lowervalue" id="lowervalue">
        </th>
  		<th style="width: 90px; background-color: #daeef3;color: black; text-align: center;">
        <select style="padding:5px 2px;" class="form-select form-select-lg" name="lowerchronological" id="lowerchronological">
            <option value="Days"> Days </option>
            <option value="Months"> Months </option>
            <option value="Years"> Years </option>
        </select>
        </th>
        
  		<th style="width: 80px; background-color: #daeef3;color: black; text-align: center;">
        <select style="padding:5px 2px;" class="form-select form-select-lg" name="highertype" id="highertype">
        <option value="<"> < </option>
        </select>
        </th>
		<th style="width: 70px; background-color: #daeef3;color: black; text-align: center;">
        <input type="text" class="form-control form-control-lg" style="padding:5px 7px;" name="highervalue" id="highervalue">
        </th>
  		<th style="width: 90px; background-color: #daeef3;color: black; text-align: center;">
        <select style="padding:5px 2px;" class="form-select form-select-lg" name="higherchronological" id="higherchronological">
        <option value="Days"> Days </option>
        <option value="Months"> Months </option>
        <option value="Years"> Years </option>
        </select>
        </th>
        
        <th colspan="2" style="width:100px; background-color: #daeef3;color: black; text-align: center;">
        <input type="text" class="form-control form-control-lg" style="padding:5px 7px;" name="malevalue" id="malevalue"></th>
		<th style="width: 70px; background-color: #daeef3;color: black; text-align: center;">
        <input type="text" class="form-control form-control-lg" style="padding:5px 7px;" name="minmalevalue" id="minmalevalue"></th>
        <th style="width: 70px; background-color: #daeef3;color: black; text-align: center;">
        <input type="text" class="form-control form-control-lg" style="padding:5px 7px;" name="maxmalevalue" id="maxmalevalue">
        </th>
        
  		<th colspan="2" style="width: 100px; background-color: #daeef3;color: black; text-align: center;">
        <input type="text" class="form-control form-control-lg" style="padding:5px 7px;" name="femalevalue" id="femalevalue"></th>
        <th style="width: 70px; background-color: #daeef3;color: black; text-align: center;">
        <input type="text" class="form-control form-control-lg" style="padding:5px 7px;" name="minfemalevalue" id="minfemalevalue"></th>
        <th style="width: 70px; background-color: #daeef3;color: black; text-align: center;">
        <input type="text" class="form-control form-control-lg" style="padding:5px 7px;" name="maxfemalevalue" id="maxfemalevalue"></th>
        <th style="width:100px; background-color: #daeef3;color: black; text-align: center; padding-bottom:15px;"><a onclick="normalRangeValidation({{$testId}});" class="btn-sm btn-info" style="text-transform:capitalize; font-weight:600; cursor:pointer;">Add More</a></th>
  		
    </tr>
  </thead>
</table> 
<div class="alert-danger pt-1 pb-1 px-1 py-1" id="referencerangealert" style="display:none;" >Please add reference range</div>


<table class="table table-bordered mt-3" id="tblreferencelist" style="display:none;">
  <thead>
  <tr>
  <th colspan="6" class="text-center">Age Limit</th>
  <th colspan="9" class="text-center">Normal Value</th>
  </tr>
    <tr>
       <th colspan="3" style="width:200px;" class="text-center">Lower </th>
       <th colspan="3" style="width:200px;" class="text-center">Upper</th>
       <th colspan="2" style="width:200px;" class="text-center">Male </th>
       <th style="width:50px;" class="text-center">Min</th>
       <th style="width:50px;" class="text-center">Max</th>
       <th colspan="2" style="width:200px;" class="text-center">Female</th>
       <th style="width:50px;" class="text-center">Min</th>
       <th style="width:50px;" class="text-center">Max</th>
       <th style="width:100px;" class="text-center">Action</th>
    </tr>
  </thead>
  <tbody> </tbody>
</table>                                            
                                              	</div>
                                              </div>  
                                              

                                                                                     
                                        </div>
                                </div>


                            <div class="card-footer">
                               
                                <a style="cursor:pointer;" class="btn btn-primary" onclick="formValidation();">Save</a>
                                <button type="submit" class="btn btn-default">Cancel</button>
                            </div>
</form>
                        </div>
                    </div>
                    
                </div> <!-- .row end -->

            </div>
        </div>


         <!-- EDIT tube POPUP STARTS HERE -->
        <form class="row g-3" id="editrange" name="editrange"  method="post" action="{{ route('range.edit') }}" >                             
                @csrf 
               
   
                    <div class="modal fade" id="edit-range-type" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Normal Range</h5>
                                    <button type="button" id="edit-modal-close-x" class="btn-close"></button>
                                </div>
                                <br><br>
                                <div class="modal-body custom_scroll">
                                    <div class="row g-4 new1">
                                      <div class="col-lg-2 mt-0">
                                        <label class="form-label">Age From</label>
                                        <input type="number" class="form-control form-control-lg" name="agefrom" id="agefrom1">
                                        <div class="alert-danger pt-1 pb-1 px-1 py-1" id="agefromalert" style="display:none ;">Please enter age from</div>
                                    </div>
                                    <div class="col-lg-2 mt-0">
                                        <label class="form-label">Age To</label>
                                        <input type="number" class="form-control form-control-lg" name="ageto" id="ageto1">
                                        <div class="alert-danger pt-1 pb-1 px-1 py-1" id="agetoalert" style="display:none ;">Please enter age to</div>
                                    </div>
                                    <div class="col-lg-2 mt-0">
                                        <label class="form-label">General</label>
                                        <input type="number" class="form-control form-control-lg"  name="generalrange" id="generalrange1">
                                        <div class="alert-danger pt-1 pb-1 px-1 py-1" id="generalrangealert" style="display:none ;">Please enter general range</div>

                                    </div>
                                    <div class="col-lg-2 mt-0">
                                        <label class="form-label">Male</label>
                                        <input type="number" class="form-control form-control-lg" name="malerange" id="malerange1">
                                    </div>
                                    <div class="col-lg-2 mt-0">
                                        <label class="form-label">Female</label>
                                        <input type="number" class="form-control form-control-lg" name="femalerange" id="femalerange1">
                                    </div>
                                    </div>
                                </div>
                            <div class="modal-footer">
                            <input type="hidden" class="form-control form-control-lg" id="hiddenid" name="hiddenid" >
                            <input type="hidden" class="form-control form-control-lg" id="testid" name="testid" >
                                        <button type="submit" id="edit-modal-close" class="btn btn-secondary" >save</button>
                                        <button type="button" id="edit-modal-close" class="btn btn-secondary3">Cancel</button>
                                        
                                        
                            </div>
                        </div>
                    </div>
                </div>


            </form> 

            <!--  EDIT CATEGORY ENDS HERE-->
    <script src="{!! asset('assets/plugin/jquery/3.3.1/jquery.min.js') !!}"></script>
<script>
    // ADD SINGLE TEST FORM VALIDATION STARTS HERE
function formValidation() 
{

    //alert('working'); exit();
    document.getElementById('testnamealert').style.display = 'none';
    document.getElementById('categoryalert').style.display = 'none'; 
    document.getElementById('primarypricealert').style.display = 'none'; 
    document.getElementById('secondarypricealert').style.display = 'none'; 
    document.getElementById('taxalert').style.display = 'none'; 
    document.getElementById('taxmethodalert').style.display = 'none'; 

    if(document.addsingletestform.testname.value == ''){
        document.getElementById('testnamealert').style.display = 'block'; 
        document.addsingletestform.testname.focus();  
        return false;     
    }else if(document.addsingletestform.testcategory.value == ''){
        document.getElementById('categoryalert').style.display = 'block'; 
        document.addsingletestform.testcategory.focus();  
        return false;     
    }
    else if(document.addsingletestform.primaryprice.value == ''){
        document.getElementById('primarypricealert').style.display = 'block'; 
        document.addsingletestform.primaryprice.focus();  
        return false;     
    }else if(IsNumeric(document.addsingletestform.primaryprice.value)==false){
        document.getElementById('primarypricealert').style.display = 'block'; 
        document.getElementById("primarypricealert").innerHTML="Invalid primary price! Please re-enter";
        document.addsingletestform.primaryprice.select();
        document.addsingletestform.primaryprice.focus(); 
        return false;
    }else if(document.addsingletestform.secondaryprice.value !=''){
    
            if(IsNumeric(document.addsingletestform.secondaryprice.value)==false){
                document.getElementById('secondarypricealert').style.display = 'block'; 
                document.getElementById("secondarypricealert").innerHTML="Invalid secondary price! Please re-enter";
                document.addsingletestform.secondaryprice.select();
                document.addsingletestform.secondaryprice.focus(); 
                return false;
            }
    }else if(document.addsingletestform.taxname.value == ''){
        alert('tax value'+document.addsingletestform.taxname.value);
        document.getElementById('taxalert').style.display = 'block';         
        return false;     
    }else if(document.addsingletestform.taxmethod.value == ''){
        document.getElementById('taxmethodalert').style.display = 'block'; 
        document.addsingletestform.taxmethod.focus();  
        return false;     
    }

    document.addsingletestform.submit();    
return true;
}

// ADD SINGLE TEST FORM VALIDATION ENDS HERE

//Update Normal range

function normalRangeSaveValidation(sid)
{
  var sid                   = sid;
  var CSRF_TOKEN            = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
  var lowertype             = document.getElementById("Listlowertype_"+sid).value;
  var lowervalue            = document.getElementById("Listlowervalue_"+sid).value;
  var lowerchronological    = document.getElementById("Listlowerchronological_"+sid).value;
  var highertype            = document.getElementById("Listhighertype_"+sid).value;
  var highervalue           = document.getElementById("Listhighervalue_"+sid).value;
  var higherchronological   = document.getElementById("Listlhigherchronological_"+sid).value;
  var malevalue             = document.getElementById("Listmalevalue_"+sid).value;
  var minmalevalue          = document.getElementById("Listminmalevalue_"+sid).value;
  var maxmalevalue          = document.getElementById("Listmaxmalevalue_"+sid).value;
  var femalevalue           = document.getElementById("Listfemalevalue_"+sid).value;
  var minfemalevalue        = document.getElementById("Listminfemalevalue_"+sid).value;
  var maxfemalevalue        = document.getElementById("Listmaxfemalevalue_"+sid).value;

  if (lowervalue.trim() === "" || highervalue.trim() === "" || malevalue.trim() === "" || femalevalue.trim() === "") {
    document.getElementById("referencerangealert").style.display = "block";
    return;
  }
  else
  {
       var normalrange = new FormData();
        normalrange.append('_token',CSRF_TOKEN);
        normalrange.append('lowertype',lowertype);
        normalrange.append('lowervalue',lowervalue);
        normalrange.append('lowerchronological',lowerchronological);
        normalrange.append('highertype',highertype);
        normalrange.append('highervalue',highervalue);
        normalrange.append('higherchronological',higherchronological);
        normalrange.append('malevalue',malevalue);
        normalrange.append('minmalevalue',minmalevalue);
        normalrange.append('maxmalevalue',maxmalevalue);
        normalrange.append('femalevalue',femalevalue);
        normalrange.append('minfemalevalue',minfemalevalue);
         normalrange.append('maxfemalevalue',maxfemalevalue);
        normalrange.append('sid',sid);
         $.ajax({
           url:"{{ route('updateRangeList') }}", 
           method: 'POST',
           data: normalrange,
           contentType: false,
           processData: false,
           dataType: 'json',
           success: function(response){
               
               var id = response.id;
        // Refresh the page with the specific ID
        window.location.href = "{{ url('update-singletest') }}/" + id;
           }

           });
       
  }
  
  

 
  
}

// ADD SINGLE TEST NORMAL RANGE FORM VALIDATION STARTS HERE

function normalRangeValidation (sid) 
{
  
  var sid                   = sid;
  var CSRF_TOKEN            = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
  var lowertype             = document.getElementById("lowertype").value;
  var lowervalue            = document.getElementById("lowervalue").value;
  var lowerchronological    = document.getElementById("lowerchronological").value;
  var highertype            = document.getElementById("highertype").value;
  var highervalue           = document.getElementById("highervalue").value;
  var higherchronological   = document.getElementById("higherchronological").value;
  var malevalue             = document.getElementById("malevalue").value;
  var minmalevalue          = document.getElementById("minmalevalue").value;
  var maxmalevalue          = document.getElementById("maxmalevalue").value;
  var femalevalue           = document.getElementById("femalevalue").value;
  var minfemalevalue        = document.getElementById("minfemalevalue").value;
  var maxfemalevalue        = document.getElementById("maxfemalevalue").value;

  if (lowervalue.trim() === "" || highervalue.trim() === "" || malevalue.trim() === "" || femalevalue.trim() === "") {
    document.getElementById("referencerangealert").style.display = "block";
    return;
  }
  else
  {
       var normalrange = new FormData();
        normalrange.append('_token',CSRF_TOKEN);
        normalrange.append('lowertype',lowertype);
        normalrange.append('lowervalue',lowervalue);
        normalrange.append('lowerchronological',lowerchronological);
        normalrange.append('highertype',highertype);
        normalrange.append('highervalue',highervalue);
        normalrange.append('higherchronological',higherchronological);
        normalrange.append('malevalue',malevalue);
        normalrange.append('minmalevalue',minmalevalue);
        normalrange.append('maxmalevalue',maxmalevalue);
        normalrange.append('femalevalue',femalevalue);
        normalrange.append('minfemalevalue',minfemalevalue);
         normalrange.append('maxfemalevalue',maxfemalevalue);
        normalrange.append('sid',sid);
         $.ajax({
           url:"{{ route('updateNormalRange') }}", 
           method: 'POST',
           data: normalrange,
           contentType: false,
           processData: false,
           dataType: 'json',
           success: function(response){
               
               var id = response.id;
        // Refresh the page with the specific ID
        window.location.href = "{{ url('update-singletest') }}/" + id;
           }

           });
       
  }
  
  

 
  
}
// DOCUMENTS ADDING ENDS HERE

// ADD SINGLE TEST NORMAL RANGE FORM VALIDATION ENDS HERE



function deletedoc(deleteid,sid,trid){
  //var el = this;
 
  // Delete id
 // var deleteid = $(this).data('id');
 
//alert(deleteid); exit();

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
  var confirmalert = confirm("Are you sure to delete?");
  if (confirmalert == true) {
     // AJAX Request
     $.ajax({
        url:"{{ 'normalrangedelete' }}",
       type: 'POST',
       data: { id:deleteid, sid:sid },
       success: function(response){
           
       //alert(response.success); exit();    
        if(response.success == 1){      
            // HIDE TABLE IF NOT RECORDS FOUND STARTS HERE
            if(response.doccount == '0' ){
                //alert(response.doccount); exit();
                document.getElementById('tablenormalrangelist').style.display = 'none';
            }        
            // HIDE TABLE IF NOT RECORDS FOUND ENDS HERE
            // REMOVE CORRESPONDING COLUMN AFTER DELETE
                $tr= $(trid).closest("tr");
                $tr.find('td').fadeOut(700, function () {
                $tr.remove();    
            });

        }else{
        alert('Invalid ID.');
        }

       }
     });
  }

}

function IsNumeric(strString)
{
   var strValidChars = "0123456789-+(). ";
   var strChar;
   var blnResult = true;
   if (strString.length == 0) return false;
   for (i = 0; i < strString.length && blnResult == true; i++)
      {
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1)
         	{
        	 blnResult = false;
         	}
      }
   return blnResult;
}






</script>


<script>
        function editview(id,sid){
            
        var token = $('input[name="_token"]').val();
        $.ajax({
        url:"{{ route('test.viewSingle')}}",
        type : 'POST',
        data:{
            id:id,
            sid:sid,
            _token:token
        },
        success:function(response){
           
            $('#agefrom1').val(response.agefrom);
            $('#ageto1').val(response.ageto);
            $('#generalrange1').val(response.generalrange);
            $('#malerange1').val(response.malerange);
            $('#femalerange1').val(response.femalerange);
            $('#hiddenid').val(response.id);
            $('#testid').val(response.singletest_id);
            $('#edit-range-type').modal('show');
            }
        });
            
        }
        $('#edit-modal-close-x, #edit-modal-close').click(function() {
                $('#edit-range-type').modal('hide');
            });
        </script>





<script src="{!! asset('assets/bundles/libscripts.bundle.js') !!}"></script>

@endsection
