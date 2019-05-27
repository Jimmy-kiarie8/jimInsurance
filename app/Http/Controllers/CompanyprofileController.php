<?php

namespace App\Http\Controllers;

use App\Companyprofile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyprofileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Companyprofile::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $company_exists =Companyprofile::first();
        if ($company_exists) {
            // $this->update($request->all(), $company_exists->id);
            $company = Companyprofile::find($company_exists->id);
        $company->company_name = $request->company_name;
        $company->email = $request->email;
        $company->phone = $request->phone;
        $company->logo = $request->logo;
        $company->address = $request->address;
        $company->website = $request->website;
        $company->save();
        return $company;
        }
        $company = new Companyprofile;
        $company->company_name = $request->company_name;
        $company->user_id = Auth::id();
        $company->email = $request->email;
        $company->phone = $request->phone;
        $company->logo = $request->logo;
        $company->address = $request->address;
        $company->website = $request->website;
        $company->save();
        return $company;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Companyprofile  $companyprofile
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Companyprofile::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Companyprofile  $companyprofile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $company = Companyprofile::find($id);
        $company->company_name = $request->company_name;
        $company->email = $request->email;
        $company->phone = $request->phone;
        $company->logo = $request->logo;
        $company->address = $request->address;
        $company->website = $request->website;
        $company->save();
        return $company;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Companyprofile  $companyprofile
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Companyprofile::find($id)->delete();
    }

	public function profilelogo(Request $request, Company $company)
	{
		// return $request->all();
		$upload = Companyprofile::find($request->id);
		if ($request->hasFile('image')) {
			$imagename = time() . $request->image->getClientOriginalName();
			$request->image->storeAs('public/logo', $imagename);
			// return response();
		}
		$image_name = '/storage/logo/' . $imagename;
		$upload->logo = $image_name;
		$upload->save();
	}
}
