<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Enums\User\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Contact\Contact;
use App\Models\User;
use App\Service\PdfExportService;

class PdfController extends Controller
{

    private string $view = 'pdf.pdf_template';

    public function __construct(protected PdfExportService $pdfExportService = new PdfExportService())
    {
    }


    public function exportUsers()
    {
        $title = 'users';
        $data = $this->getPersonalData(RoleEnum::User->value);
        if (empty($data)) {
            return $this->errorResponse(message: __('messages.no_data_found'));
        }

        $filePath = $this->pdfExportService->generatePdf(
            view: $this->view,
            data: compact("data", "title"),
            fileName: $title
        );

        return $this->successResponse(data: $filePath, message: __('messages.success'));
    }

    public function exportEmployees()
    {
        $title = 'employees';
        $data = $this->getPersonalData(RoleEnum::Employee->value);
        if (empty($data)) {
            return $this->errorResponse(message: __('messages.no_data_found'));
        }
        $filePath = $this->pdfExportService->generatePdf(
            view: $this->view,
            data: compact("data", "title"),
            fileName: $title
        );
        return $this->successResponse(data: $filePath, message: __('messages.success'));
    }

    public function exportContactUs()
    {
        $title = 'contacts';
        $data = Contact::query()->latest()->select("id", "name", "email", "phone", "message", "subject")->get();

        if (empty($data)) {
            return $this->errorResponse(message: __('messages.no_data_found'));
        }


        $filePath = $this->pdfExportService->generatePdf(
            view: $this->view,
            data: compact("data", "title"),
            fileName: $title
        );

        return $this->successResponse(data: $filePath, message: __('messages.success'));
    }


    private function getPersonalData($role)
    {
        return User::query()->where("role", $role)->latest()
            ->select("id", "name", "email", "phone")
            ->get();
    }
}
