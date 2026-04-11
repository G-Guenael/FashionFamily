<?php
require_once __DIR__ . '/../../../core/BaseController.php';
require_once __DIR__ . '/../../../utils/Auth.php';
require_once __DIR__ . '/../../models/Order.php';

class AdminOrderController extends BaseController
{
    private Order $orderModel;

    public function __construct()
    {
        $this->orderModel = new Order();
    }

    // POST /admin/orders/status — mettre à jour le statut d'une commande
    public function updateStatus(): void
    {
        Auth::requireAdmin();

        if (!Session::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Session::setFlash('error', 'Session expirée, veuillez réessayer.');
            $this->redirect('/admin#orders');
            return;
        }

        $id      = (int) ($_POST['id'] ?? 0);
        $status  = $_POST['status'] ?? '';
        $allowed = ['pending', 'paid', 'shipped', 'delivered', 'cancelled'];

        if (!$id || !in_array($status, $allowed)) {
            Session::setFlash('error', 'Données invalides.');
            $this->redirect('/admin#orders');
            return;
        }

        $this->orderModel->updateStatus($id, $status);
        Session::setFlash('success', 'Statut de la commande #' . $id . ' mis à jour.');
        $this->redirect('/admin#orders');
    }
}
