<?php
require_once 'ActivityDetailsCRUD.php';

$activityDetailsCRUD = new ActivityDetailsCRUD();
$activities = $activityDetailsCRUD->readAllActivities();

$status = isset($_GET['status']) && in_array($_GET['status'], ['success', 'error'], true) ? $_GET['status'] : null;
$message = isset($_GET['message']) ? $_GET['message'] : null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Ledger</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@500;600&family=Public+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <header class="site-header">
        <div>
            <h1>Activity Ledger</h1>
            <p>Record instructor-led activities, keep details up to date, and collect feedback from students.</p>
        </div>
        <button type="button" class="theme-toggle">Dark mode</button>
    </header>

    <div class="layout">
        <ul class="tabs">
            <li><a href="#overview">Overview</a></li>
            <li><a href="#new-entry">New entry</a></li>
            <li><a href="#update">Update</a></li>
            <li><a href="#remove">Remove</a></li>
            <li><a href="#feedback">Feedback</a></li>
        </ul>

        <div class="ledger">
            <section id="overview" class="panel">
                <h2>Activities on record</h2>
                <p class="panel-hint">Every activity currently stored, read live from the database.</p>

                <?php if ($status && $message): ?>
                    <div class="banner <?= $status === 'success' ? 'success' : 'error' ?>">
                        <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($activities)): ?>
                    <div class="table-wrap">
                        <table class="ledger-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Activity</th>
                                    <th>Instructor ID</th>
                                    <th>Major</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Attachment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($activities as $activity): ?>
                                    <tr>
                                        <td><?= htmlspecialchars((string) $activity->Id, ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars($activity->Activity_Name, ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars((string) $activity->user_id, ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars($activity->Major, ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars($activity->start_date, ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars($activity->end_date, ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= $activity->attachment !== '' ? htmlspecialchars($activity->attachment, ENT_QUOTES, 'UTF-8') : '&mdash;' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="empty-state">No activity details found yet. Use "New entry" to add the first one.</p>
                <?php endif; ?>
            </section>

            <section id="new-entry" class="panel">
                <h2>New entry</h2>
                <p class="panel-hint">Add an activity to the ledger. Choose an ID that isn't already in use.</p>
                <form action="ActivityDetailsController.php" method="post">
                    <div class="form-grid">
                        <div class="field">
                            <label for="create-id">Activity ID</label>
                            <input type="number" id="create-id" name="Id" required min="1">
                        </div>
                        <div class="field">
                            <label for="create-name">Activity name</label>
                            <input type="text" id="create-name" name="Activity_Name" required maxlength="222">
                        </div>
                        <div class="field">
                            <label for="create-instructor">Instructor ID</label>
                            <input type="number" id="create-instructor" name="user_id" required min="1">
                        </div>
                        <div class="field">
                            <label for="create-major">Major</label>
                            <input type="text" id="create-major" name="Major" required maxlength="222">
                        </div>
                        <div class="field">
                            <label for="create-start">Start date</label>
                            <input type="date" id="create-start" name="start_date" required>
                        </div>
                        <div class="field">
                            <label for="create-end">End date</label>
                            <input type="date" id="create-end" name="end_date" required>
                        </div>
                        <div class="field full">
                            <label for="create-attachment">Attachment (optional)</label>
                            <input type="text" id="create-attachment" name="attachment" maxlength="222" placeholder="Filename or link">
                        </div>
                    </div>
                    <div class="actions">
                        <button type="submit" name="create" value="Create" class="btn">Add activity</button>
                    </div>
                </form>
            </section>

            <section id="update" class="panel">
                <h2>Update an entry</h2>
                <p class="panel-hint">Enter the ID of an existing activity along with its new details.</p>
                <form action="ActivityDetailsController.php" method="post">
                    <div class="form-grid">
                        <div class="field">
                            <label for="update-id">Activity ID</label>
                            <input type="number" id="update-id" name="Id" required min="1">
                        </div>
                        <div class="field">
                            <label for="update-name">Activity name</label>
                            <input type="text" id="update-name" name="Activity_Name" required maxlength="222">
                        </div>
                        <div class="field">
                            <label for="update-instructor">Instructor ID</label>
                            <input type="number" id="update-instructor" name="user_id" required min="1">
                        </div>
                        <div class="field">
                            <label for="update-major">Major</label>
                            <input type="text" id="update-major" name="Major" required maxlength="222">
                        </div>
                        <div class="field">
                            <label for="update-start">Start date</label>
                            <input type="date" id="update-start" name="start_date" required>
                        </div>
                        <div class="field">
                            <label for="update-end">End date</label>
                            <input type="date" id="update-end" name="end_date" required>
                        </div>
                        <div class="field full">
                            <label for="update-attachment">Attachment (optional)</label>
                            <input type="text" id="update-attachment" name="attachment" maxlength="222" placeholder="Filename or link">
                        </div>
                    </div>
                    <div class="actions">
                        <button type="submit" name="update" value="Update" class="btn">Save changes</button>
                    </div>
                </form>
            </section>

            <section id="remove" class="panel">
                <h2>Remove an entry</h2>
                <p class="panel-hint">This deletes the activity permanently. Double-check the ID before continuing.</p>
                <form action="ActivityDetailsController.php" method="post">
                    <div class="form-grid">
                        <div class="field">
                            <label for="delete-id">Activity ID</label>
                            <input type="number" id="delete-id" name="Id" required min="1">
                        </div>
                    </div>
                    <div class="actions">
                        <button type="submit" name="delete" value="Delete" class="btn danger">Delete activity</button>
                    </div>
                </form>
            </section>

            <section id="feedback" class="panel">
                <h2>Leave feedback</h2>
                <p class="panel-hint">Share a comment about an instructor's activity.</p>
                <form action="ActivityDetailsController.php" method="post">
                    <div class="form-grid">
                        <div class="field">
                            <label for="feedback-name">Full name</label>
                            <input type="text" id="feedback-name" name="FullName" required maxlength="222">
                        </div>
                        <div class="field">
                            <label for="feedback-email">Email</label>
                            <input type="email" id="feedback-email" name="email" required maxlength="222">
                        </div>
                        <div class="field">
                            <label for="feedback-instructor">Instructor ID</label>
                            <input type="number" id="feedback-instructor" name="Instructor_id" required min="1">
                        </div>
                        <div class="field full">
                            <label for="feedback-message">Message</label>
                            <textarea id="feedback-message" name="message" required maxlength="500"></textarea>
                        </div>
                    </div>
                    <div class="actions">
                        <button type="submit" name="feedback" value="Submit" class="btn">Send feedback</button>
                    </div>
                </form>
            </section>
        </div>
    </div>

    <script src="assets/app.js"></script>
</body>

</html>
