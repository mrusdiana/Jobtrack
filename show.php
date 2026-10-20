<?php

require_once __DIR__ . "/config/database.php" ;

$id = $_GET["id"] ?? null;

$id = filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" >= 1]]);

$application = false ;

echo $applications, "<<<<<<";

if($id !== false) {

    $sql = "SELECT *
            FROM applications
            WHERE id = :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt -> execute([":id" => $id]);

    $application = $stmt->fetch(PDO::FETCH_ASSOC);
}

if($application === false) {
    http_response_code(404);
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Application detail</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4/dist/full.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100">
<main class="mx-auto max-w-2xl px-4 py-10">

    <a href="index.php" class="text-sm font-semibold text-slate-500 hover:text-slate-900">&larr; Back to list</a>

    <?php if ($application === false): ?>

        <div class="mt-6 rounded-3xl border-2 border-dashed border-slate-300 p-10 text-center">
            <h1 class="font-bold text-slate-700">Application not found</h1>
            <p class="mt-1 text-sm text-slate-500">It may have been deleted.</p>
        </div>

    <?php else: ?>

        <div class="mt-4 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200 md:p-8">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900"><?= htmlspecialchars($application["company"]) ?></h1>
                    <p class="text-slate-500"><?= htmlspecialchars($application["position"]) ?></p>
                </div>
                <span class="badge badge-lg font-semibold"><?= htmlspecialchars($application["status"]) ?></span>
            </div>

            <dl class="mt-6 grid gap-4 border-t border-slate-100 pt-6 text-sm sm:grid-cols-2">
                <div>
                    <dt class="text-slate-400">Location</dt>
                    <dd class="font-semibold text-slate-700"><?= htmlspecialchars($application["location"]) ?></dd>
                </div>
                <div>
                    <dt class="text-slate-400">Applied date</dt>
                    <dd class="font-semibold text-slate-700"><?= htmlspecialchars($application["applied_date"]) ?></dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-slate-400">Job URL</dt>
                    <dd class="font-semibold text-slate-700">
                        <?php if (!empty($application["job_url"])): ?>
                            <!-- Hanya link http/https yang dijadikan <a>, supaya "javascript:..." tidak bisa lolos -->
                            <?php if (preg_match('#^https?://#i', $application["job_url"])): ?>
                                <a class="link" target="_blank" rel="noopener noreferrer"
                                   href="<?= htmlspecialchars($application["job_url"]) ?>"><?= htmlspecialchars($application["job_url"]) ?></a>
                            <?php else: ?>
                                <?= htmlspecialchars($application["job_url"]) ?>
                            <?php endif; ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-slate-400">Notes</dt>
                    <!-- whitespace-pre-line: baris baru di catatan tetap terlihat -->
                    <dd class="whitespace-pre-line font-semibold text-slate-700"><?= htmlspecialchars($application["notes"] ?? "") ?: "-" ?></dd>
                </div>
            </dl>

            <div class="mt-6 flex items-center gap-2">
                <a href="edit.php?id=<?= (int) $application["id"] ?>" class="btn btn-sm btn-outline">Edit</a>
                <form method="POST" action="delete.php" class="ml-auto"
                      onsubmit="return confirm('Delete this application?')">
                    <input type="hidden" name="id" value="<?= (int) $application["id"] ?>">
                    <button type="submit" class="btn btn-sm btn-error btn-outline">Delete</button>
                </form>
            </div>
        </div>

    <?php endif; ?>

</main>
</body>
</html>
