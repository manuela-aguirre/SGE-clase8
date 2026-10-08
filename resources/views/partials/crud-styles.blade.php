<style>
    .crud-wrap { padding: 1.5rem 1rem; }
    .crud-toolbar { display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap; margin-bottom: 1.25rem; }
    .crud-search input { border-radius: 0.75rem; border: 1px solid #dcfce7; padding: 0.55rem 0.9rem; min-width: 260px; }
    .crud-btn-new { background: #14532d; color: white; padding: 0.6rem 1.1rem; border-radius: 0.75rem; font-weight: 600; font-size: 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; }
    .crud-btn-new:hover { background: #166534; }
    table.crud-table { width: 100%; border-collapse: collapse; background: white; border-radius: 1rem; overflow: hidden; }
    table.crud-table th { background: #f0fdf4; color: #14532d; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 0.06em; padding: 0.85rem 1rem; text-align: left; }
    table.crud-table td { padding: 0.85rem 1rem; border-top: 1px solid #f1f5f9; font-size: 0.9rem; color: #334155; }
    .crud-badge { background: #f0fdf4; color: #14532d; padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.72rem; font-weight: 600; }
    .crud-badge.warn { background: #fef3c7; color: #92400e; }
    .crud-actions a, .crud-actions button { font-size: 0.78rem; font-weight: 600; margin-right: 0.75rem; text-decoration: none; }
    .crud-actions a.edit, .crud-actions button.pay { color: #14532d; background: none; border: none; cursor: pointer; padding: 0; }
    .crud-actions button.delete { color: #b91c1c; background: none; border: none; cursor: pointer; padding: 0; }
    .status-banner { background: #dcfce7; color: #14532d; padding: 0.75rem 1rem; border-radius: 0.75rem; margin-bottom: 1rem; font-weight: 600; font-size: 0.88rem; }
    .status-banner.error { background: #fee2e2; color: #991b1b; }
    .empty-state { text-align: center; padding: 3rem 1rem; color: #64748b; }
    .crud-form { max-width: 640px; }
    .crud-form .field { margin-bottom: 1.1rem; }
    .crud-form input[type=text], .crud-form input[type=number], .crud-form input[type=email],
    .crud-form input[type=date], .crud-form textarea, .crud-form select {
        width: 100%; border-radius: 0.75rem; border: 1px solid #dcfce7; padding: 0.6rem 0.9rem; margin-top: 0.35rem;
    }
    .crud-form label { font-weight: 600; color: #14532d; font-size: 0.85rem; }
    .crud-form .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .crud-form .actions { margin-top: 1.5rem; display: flex; gap: 0.75rem; }
    .crud-form .btn-cancel { padding: 0.6rem 1.1rem; border-radius: 0.75rem; font-weight: 600; font-size: 0.85rem; text-decoration: none; color: #475569; background: #f1f5f9; }
</style>
