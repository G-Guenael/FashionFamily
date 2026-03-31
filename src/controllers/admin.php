<?php
require_once MODELS_PATH . '/User.php';
require_once MODELS_PATH . '/Article.php';

function dashboard()
{
    requireAdmin();

    $data = [
        'totalUsers' => countUsers(),
        'totalArticles' => count(getAllArticles()),
    ];

    view('admin/sections/dashboard', $data);
}

function products()
{
    requireAdmin();
    $data = [
        'articles' => getAllArticles(),
    ];
    view('admin/sections/products', $data);
}

function orders()
{
    requireAdmin();
    view('admin/sections/orders');
}

function customers()
{
    requireAdmin();

    $data = ['users' => getAllUsers()];
    view('admin/sections/customers', $data);
}

function reviews()
{
    requireAdmin();
    view('admin/sections/reviews');
}

function settings()
{
    requireAdmin();
    view('admin/sections/settings', ['user' => currentUser()]);
}

function updateProfile()
{
    requireAdmin();

    if (!isMethod('POST') || !verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        redirect('dashboard');
        return;
    }

    $id    = $_SESSION['user_id'];
    $name  = clean($_POST['name'] ?? '');
    $email = clean($_POST['email'] ?? '');

    $validationErrors = validate(
        ['name' => $name, 'email' => $email],
        ['name' => ['required'], 'email' => ['required', 'email']]
    );

    if (!empty($validationErrors)) {
        $errors = array_merge(...array_values($validationErrors));
        setFlashMessage('error', implode(', ', $errors));
        redirect('dashboard');
        return;
    }

    updateUser($id, ['name' => $name, 'email' => $email, 'role' => 'admin']);
    setFlashMessage('success', 'Profil mis à jour.');
    redirect('dashboard');
}

function updatePassword()
{
    requireAdmin();

    if (!isMethod('POST') || !verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        redirect('dashboard');
        return;
    }

    $current  = $_POST['current_password'] ?? '';
    $new      = $_POST['new_password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    $admin = getUserByEmail(currentUser()['email']);

    if (!password_verify($current, $admin['password'] ?? '')) {
        setFlashMessage('error', 'Mot de passe actuel incorrect.');
        redirect('dashboard');
        return;
    }

    if ($new !== $confirm || strlen($new) < 6) {
        setFlashMessage('error', 'Les mots de passe ne correspondent pas ou sont trop courts (min. 6 caractères).');
        redirect('dashboard');
        return;
    }

    changeUserPassword($_SESSION['user_id'], $new);
    setFlashMessage('success', 'Mot de passe mis à jour.');
    redirect('dashboard');
}

function editUser(int $id)
{
    requireAdmin();

    $user = getUserById($id);
    if (!$user) {
        redirect('dashboard');
        return;
    }

    if (isMethod('POST')) {
        if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            setFlashMessage('error', 'Session expirée, veuillez réessayer.');
            redirect('admin', 'editUser', [$id]);
            return;
        }

        $name  = clean($_POST['name'] ?? '');
        $email = clean($_POST['email'] ?? '');
        $role  = in_array($_POST['role'] ?? '', ['user', 'admin']) ? $_POST['role'] : 'user';

        $validationErrors = validate(
            ['name' => $name, 'email' => $email],
            ['name' => ['required'], 'email' => ['required', 'email']]
        );

        if (!empty($validationErrors)) {
            $errors = array_merge(...array_values($validationErrors));
            view('admin/editUser', ['title' => 'Modifier utilisateur', 'user' => $user, 'errors' => $errors]);
            return;
        }

        updateUser($id, ['name' => $name, 'email' => $email, 'role' => $role]);
        setFlashMessage('success', 'Utilisateur mis à jour.');
        redirect('dashboard');
        return;
    }

    view('admin/editUser', [
        'title'       => 'Modifier utilisateur',
        'description' => 'Modifier un utilisateur',
        'user'        => $user,
    ]);
}

function removeUser(int $id)
{
    requireAdmin();

    if (!isMethod('POST') || !verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        redirect('dashboard');
        return;
    }

    deleteUser($id);
    setFlashMessage('success', 'Utilisateur supprimé.');
    redirect('dashboard');
}

function editArticle(int $id)
{
    requireAdmin();

    $article = getArticleById($id);
    if (!$article) {
        redirect('dashboard');
        return;
    }

    if (isMethod('POST')) {
        if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            setFlashMessage('error', 'Session expirée, veuillez réessayer.');
            redirect('admin', 'editArticle', [$id]);
            return;
        }

        $data = [
            'title'             => clean($_POST['title'] ?? ''),
            'description'       => clean($_POST['description'] ?? ''),
            'price'             => (float) ($_POST['price'] ?? 0),
            'quantity'          => (int) ($_POST['quantity'] ?? 0),
            'article_condition' => clean($_POST['article_condition'] ?? ''),
            'status'            => in_array($_POST['status'] ?? '', ['active', 'inactive']) ? $_POST['status'] : 'inactive',
        ];

        $validationErrors = validate(
            ['title' => $data['title'], 'price' => $data['price']],
            ['title' => ['required'], 'price' => ['required']]
        );

        if (!empty($validationErrors)) {
            $errors = array_merge(...array_values($validationErrors));
            view('admin/editArticle', ['title' => 'Modifier article', 'article' => $article, 'errors' => $errors]);
            return;
        }

        updateArticle($id, $data);
        setFlashMessage('success', 'Article mis à jour.');
        redirect('dashboard');
        return;
    }

    view('admin/editArticle', [
        'title'       => 'Modifier article',
        'description' => 'Modifier un article',
        'article'     => $article,
    ]);
}

function removeArticle(int $id)
{
    requireAdmin();

    if (!isMethod('POST') || !verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        redirect('dashboard');
        return;
    }

    deleteArticle($id);
    setFlashMessage('success', 'Article supprimé.');
    redirect('dashboard');
}

function stats()
{
    requireAdmin();

    header('Content-Type: application/json');
    echo json_encode([
        'articles' => getArticlesCountByMonth(),
        'users'    => getUsersCountByMonth(),
    ]);
    exit;
}
