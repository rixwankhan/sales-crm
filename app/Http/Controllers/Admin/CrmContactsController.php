<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCrmContactRequest;
use App\Http\Requests\StoreCrmContactRequest;
use App\Http\Requests\UpdateCrmContactRequest;
use App\Models\CrmContact;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CrmContactsController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('crm_contact_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crmContacts = CrmContact::with(['created_by'])->get();

        return view('admin.crmContacts.index', compact('crmContacts'));
    }

    public function create()
    {
        abort_if(Gate::denies('crm_contact_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.crmContacts.create');
    }

    public function store(StoreCrmContactRequest $request)
    {
        $crmContact = CrmContact::create($request->all());

        return redirect()->route('admin.crm-contacts.index');
    }

    public function edit(CrmContact $crmContact)
    {
        abort_if(Gate::denies('crm_contact_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crmContact->load('created_by');

        return view('admin.crmContacts.edit', compact('crmContact'));
    }

    public function update(UpdateCrmContactRequest $request, CrmContact $crmContact)
    {
        $crmContact->update($request->all());

        return redirect()->route('admin.crm-contacts.index');
    }

    public function show(CrmContact $crmContact)
    {
        abort_if(Gate::denies('crm_contact_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crmContact->load('created_by');

        return view('admin.crmContacts.show', compact('crmContact'));
    }

    public function destroy(CrmContact $crmContact)
    {
        abort_if(Gate::denies('crm_contact_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crmContact->delete();

        return back();
    }

    public function massDestroy(MassDestroyCrmContactRequest $request)
    {
        $crmContacts = CrmContact::find(request('ids'));

        foreach ($crmContacts as $crmContact) {
            $crmContact->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
