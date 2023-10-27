<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCrmContactRequest;
use App\Http\Requests\UpdateCrmContactRequest;
use App\Http\Resources\Admin\CrmContactResource;
use App\Models\CrmContact;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CrmContactsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('crm_contact_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CrmContactResource(CrmContact::with(['created_by'])->get());
    }

    public function store(StoreCrmContactRequest $request)
    {
        $crmContact = CrmContact::create($request->all());

        return (new CrmContactResource($crmContact))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CrmContact $crmContact)
    {
        abort_if(Gate::denies('crm_contact_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CrmContactResource($crmContact->load(['created_by']));
    }

    public function update(UpdateCrmContactRequest $request, CrmContact $crmContact)
    {
        $crmContact->update($request->all());

        return (new CrmContactResource($crmContact))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CrmContact $crmContact)
    {
        abort_if(Gate::denies('crm_contact_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crmContact->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
