<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class ApiBaseController extends ResourceController
{
    protected $db;
    protected $format = 'json';

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);
        $this->db = \Config\Database::connect();
    }

    protected function validateToken()
    {
        $token = $this->request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $token);

        $validToken = $this->db->table('pengaturan')
            ->where('key', 'api_token')
            ->get()
            ->getRow();

        if (!$validToken || $validToken->value !== $token) {
            return $this->respond(['error' => 'Unauthorized', 'message' => 'Token tidak valid.'], 401);
        }

        return null;
    }

    protected function paginate($builder, $perPage = 20)
    {
        $page = (int) ($this->request->getGet('page') ?? 1);
        $total = $builder->countAllResults(false);
        $data = $builder->get($perPage, ($page - 1) * $perPage)->getResultArray();

        return [
            'data' => $data,
            'meta' => [
                'total' => $total,
                'page' => $page,
                'per_page' => $perPage,
                'total_pages' => ceil($total / $perPage),
            ],
        ];
    }
}
