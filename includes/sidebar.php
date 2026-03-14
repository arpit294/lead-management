<header>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
     <link rel="stylesheet" href="css/sidebar.css">
  </header>
<div class="sidebar">

<div class="sidebar-title">
Menu
</div>

<a href="dashboard.php" class="<?php if(basename($_SERVER['PHP_SELF'])=='dashboard.php') echo 'active'; ?>">
<i class="bi bi-speedometer2"></i>
Dashboard
</a>

<a href="leads.php" class="<?php if(basename($_SERVER['PHP_SELF'])=='leads.php') echo 'active'; ?>">
<i class="bi bi-people"></i>
Leads
</a>

<a href="add_lead.php" class="<?php if(basename($_SERVER['PHP_SELF'])=='add_lead.php') echo 'active'; ?>">
<i class="bi bi-person-plus"></i>
Add Lead
</a>

</div>