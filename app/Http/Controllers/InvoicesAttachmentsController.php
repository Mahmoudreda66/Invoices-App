<?php

namespace App\Http\Controllers;

use App\InvoicesAttachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoicesAttachmentsController extends Controller
{
    public function show($file)
    {
        $files = Storage::disk('attachments')->getDriver()->getAdapter()->applyPathPrefix($file);
        return response()->file($files);
    }

    public function download($file)
    {

        $files = Storage::disk('attachments')->getDriver()->getAdapter()->applyPathPrefix($file);
        return response()->download($files);
    }

    public function destroy(Request $request)
    {
        $attachment = InvoicesAttachments::findOrFail($request->id);

        $fileName = $attachment->first()->select('file_name')->get()[0]->file_name;

        Storage::disk('attachments')->delete($fileName);

        $attachment->delete();

        return redirect()->back()->with(['success' => 'تم حذف المرفق بنجاح']);
    }

    public function store(Request $request, $id)
    {
        if($request->hasfile('attachment')){

            $this->validate($request, ['attachment' => 'mimes:pdf,jpg,jpeg,png,gif'], [
                'attachments.mimes' => 'صيغ الملفات المتاحة فقط هي: pdf, jpg, jpeg, png, gif'
            ]);

            $file = $request->file('attachment');
            $fileName = time() . '-' . $file->getClientOriginalName();
            
            $file->move(public_path('invoices_attachments'), $fileName);

            InvoicesAttachments::create([
                'file_name' => $fileName,
                'invoice_id' => $request->id,
                'user' => auth()->user()->id
            ]);

            return redirect()->back()->with(['success' => 'تم إضافة المرفق بنجاح']);

        }
    }
}
