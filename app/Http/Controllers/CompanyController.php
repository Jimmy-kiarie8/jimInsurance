<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Auth;

class CompanyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $company = new Company;
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request->all();
        $company = Company::find($id);
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }
    
	public function getCompanies() {
		return json_decode(json_encode(Company::all()), true);
	}
	public function getCompanyAdmin() {
		$userRoles = User::with(['roles'])->get();
		$user = [];
		$IdArr = [];
		foreach ($userRoles as $value) {
			foreach ($value->roles as $element) {
				$role_name = $element->name;
				$role_id = $element->id;
				if ($role_name == 'companyAdmin') {
					$user[] = $value;
				}
			}
		}
		return $user;
	}

	public function logo(Request $request, Company $company)
	{
		// return $request->all();
		$upload = Company::find($request->id);
		if ($request->hasFile('image')) {
			$imagename = time() . $request->image->getClientOriginalName();
			$request->image->storeAs('public/logo', $imagename);
			// return response();
		}
		$image_name = '/storage/logo/' . $imagename;
		$upload->logo = $image_name;
		$upload->save();
	}

	public function getLogo()
	{
		return Company::where('id', Auth::user()->branch_id)->get();
	}



	public function getLogoOnly()
	{
		$companies = Company::where('id', Auth::user()->branch_id)->get();
		foreach ($companies as $company) {
			$company_logo = $company->logo;
		}
		return $company_logo;
	}
}
