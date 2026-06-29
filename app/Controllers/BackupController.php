<?php

namespace App\Controllers;

class BackupController extends BaseController
{
    public function index()
    {
        $data = ['title' => 'Backup Database'];

        $tables = $this->db->listTables();
        $data['tables'] = $tables;
        $data['total_tables'] = count($tables);

        $total_rows = 0;
        foreach ($tables as $table) {
            $total_rows += $this->db->table($table)->countAllResults();
        }
        $data['total_rows'] = $total_rows;

        return $this->view('backup/index', $data);
    }

    public function download()
    {
        $tables = $this->db->listTables();
        $sql = "-- SIPUS Database Backup\n";
        $sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
        $sql .= "-- Database: sipus\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            $sql .= "-- ----------------------------\n";
            $sql .= "-- Table: $table\n";
            $sql .= "-- ----------------------------\n";

            $create = $this->db->query("SHOW CREATE TABLE `$table`")->getRowArray();
            $sql .= $create['Create Table'] . ";\n\n";

            $rows = $this->db->table($table)->get()->getResultArray();
            if (!empty($rows)) {
                $columns = array_keys($rows[0]);
                $sql .= "INSERT INTO `$table` (`" . implode('`, `', $columns) . "`) VALUES\n";
                $values = [];
                foreach ($rows as $row) {
                    $escaped = array_map(function ($v) {
                        if ($v === null) return 'NULL';
                        return "'" . addslashes($v) . "'";
                    }, array_values($row));
                    $values[] = '(' . implode(', ', $escaped) . ')';
                }
                $sql .= implode(",\n", $values) . ";\n\n";
            }
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        $filename = 'sipus_backup_' . date('Y-m-d_His') . '.sql';
        $user = session()->get('user');

        $this->db->table('backup_history')->insert([
            'id_user'    => $user['id'],
            'filename'   => $filename,
            'ukuran'     => strlen($sql),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $this->logActivity('Backup database', 'backup', "File: $filename");

        header('Content-Type: application/sql; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . strlen($sql));
        header('Pragma: no-cache');

        echo $sql;
        exit;
    }

    public function history()
    {
        $pager = service('pager');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->getPerPage();

        $builder = $this->db->table('backup_history')
            ->select('backup_history.*, users.nama')
            ->join('users', 'users.id = backup_history.id_user')
            ->orderBy('backup_history.created_at', 'DESC');

        $total = $builder->countAllResults(false);

        $data = [
            'title' => 'Riwayat Backup',
            'backups' => $builder->get($perPage, ($page - 1) * $perPage)->getResultArray(),
            'pager_links' => $pager->makeLinks($page, $perPage, $total),
            'currentPage' => (int)$page,
            'perPage' => $perPage,
        ];

        return $this->view('backup/history', $data);
    }

    public function restore()
    {
        $data = ['title' => 'Restore Database'];
        return $this->view('backup/restore', $data);
    }

    public function restoreProcess()
    {
        $file = $this->request->getFile('backup_file');

        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Pilih file backup yang valid.');
        }

        $ext = $file->getExtension();
        if ($ext !== 'sql') {
            return redirect()->back()->with('error', 'File harus berformat .sql');
        }

        if ($file->getSizeByUnit('mb') > 50) {
            return redirect()->back()->with('error', 'Ukuran file maksimal 50MB.');
        }

        $sql = file_get_contents($file->getTempName());

        $this->db->transStart();

        try {
            $queries = array_filter(array_map('trim', explode(';', $sql)));
            foreach ($queries as $query) {
                if (!empty($query) && $query !== 'SET FOREIGN_KEY_CHECKS=0' && $query !== 'SET FOREIGN_KEY_CHECKS=1') {
                    $this->db->query($query);
                }
            }
            $this->db->transComplete();
        } catch (\Exception $e) {
            $this->db->transRollback();
            return redirect()->back()->with('error', 'Gagal restore: ' . $e->getMessage());
        }

        $this->logActivity('Restore database', 'backup', 'File: ' . $file->getName());
        return redirect()->to('/backup')->with('success', 'Database berhasil di-restore.');
    }
}
