<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    :root {
        --primary: #10B981; /* Emerald 500 */
        --primary-dark: #059669; /* Emerald 600 */
        --primary-light: #D1FAE5; /* Emerald 100 */
        --bg-body: #F3F4F6;
        --bg-card: #FFFFFF;
        --text-dark: #111827;
        --text-gray: #6B7280;
        --border-color: #E5E7EB;
        --success: #10B981;
        --warning: #F59E0B;
        --danger: #EF4444;
        --sidebar-width: 260px;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--bg-body);
        color: var(--text-dark);
        display: flex;
        min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
        width: var(--sidebar-width);
        background: var(--bg-card);
        border-right: 1px solid var(--border-color);
        position: fixed;
        height: 100vh;
        z-index: 50;
        display: flex;
        flex-direction: column;
        padding: 1.5rem;
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 700;
        font-size: 1.25rem;
        color: var(--text-dark);
        margin-bottom: 2.5rem;
        padding-left: 0.5rem;
    }
    
    .brand-logo {
        width: 32px; height: 32px;
        background: var(--primary);
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        color: white;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        padding: 0.875rem 1rem;
        color: var(--text-gray);
        text-decoration: none;
        border-radius: 0.75rem;
        font-weight: 500;
        transition: all 0.2s;
        margin-bottom: 0.25rem;
    }

    .nav-link:hover, .nav-link.active {
        background-color: var(--primary);
        color: white;
        box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.1), 0 2px 4px -1px rgba(16, 185, 129, 0.06);
    }
    
    /* Layout */
    .main-wrapper {
        flex: 1;
        margin-left: var(--sidebar-width);
        display: flex;
        flex-direction: column;
    }

    /* Header */
    .top-bar {
        height: 80px;
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 2rem;
    }

    .welcome-text h1 { font-size: 1.5rem; font-weight: 700; color: var(--text-dark); }
    .welcome-text p { color: var(--text-gray); font-size: 0.875rem; }

    .header-actions { display: flex; align-items: center; gap: 1.5rem; }
    
    .search-bar {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 0.75rem;
        padding: 0.625rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        width: 300px;
    }
    .search-bar input { border: none; outline: none; width: 100%; color: var(--text-dark); }
    
    .btn-new {
        background: var(--primary);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        display: flex; align-items: center; gap: 0.5rem;
        text-decoration: none;
    }
    /* Components */
    .card {
        background: var(--bg-card);
        border-radius: 1rem;
        border: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-bottom: 1.5rem;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    /* Dashboard Content */
    .content-area { padding: 0 2rem 2rem 2rem; }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--bg-card);
        border-radius: 1rem;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 1.25rem;
    }

    .stat-icon {
        width: 60px; height: 60px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem;
    }

    .stat-info h3 { color: var(--text-gray); font-size: 0.875rem; font-weight: 500; margin-bottom: 0.25rem; }
    .stat-info .value { color: var(--text-dark); font-size: 1.5rem; font-weight: 700; }
    .stat-change { font-size: 0.75rem; font-weight: 600; margin-top: 0.25rem; display: flex; align-items: center; gap: 0.25rem; }
    .text-up { color: var(--success); }
    .text-down { color: var(--danger); }

    .charts-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .chart-card {
        background: var(--bg-card);
        border-radius: 1rem;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
    }
    
    .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
    .section-title { font-size: 1.125rem; font-weight: 700; }

    /* Tables */
    .custom-table { width: 100%; border-collapse: separate; border-spacing: 0; }
    .custom-table th { text-align: left; color: var(--text-gray); font-size: 0.75rem; font-weight: 600; padding: 1rem; border-bottom: 1px solid var(--border-color); }
    .custom-table td { padding: 1rem; border-bottom: 1px solid var(--border-color); font-size: 0.875rem; }
    .custom-table tr:last-child td { border-bottom: none; }
    
    .user-avatar { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; }
    .status-badge { padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; }
    .bg-success-light { background: #D1FAE5; color: #065F46; }
    .bg-warning-light { background: #FEF3C7; color: #92400E; }
    
    /* Responsive Design */
    @media (max-width: 1024px) {
        :root { --sidebar-width: 0px; }
        .sidebar { transform: translateX(-100%); transition: transform 0.3s ease; width: 260px; }
        .sidebar.open { transform: translateX(0); }
        .main-wrapper { margin-left: 0; }
        
        .charts-grid { grid-template-columns: 1fr; }
        .stats-grid { grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); }
        
        .mobile-toggle { display: block !important; }
        .top-bar { 
            padding: 1rem; 
            height: auto; 
            flex-direction: column; 
            align-items: flex-start; 
            gap: 1rem; 
        }
        .header-actions { 
            width: 100%; 
            justify-content: space-between; 
            gap: 0.5rem; 
        }
        .search-bar { width: 100%; }
        .btn-new { display: none; } /* Hide 'New Campaign' on mobile to save space */
        .content-area { padding: 1rem; }
        
        .welcome-text h1 { font-size: 1.25rem; }
        .welcome-text p { display: none; } /* Hide subtitle on mobile */
    }
    
    .mobile-toggle { display: none; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--text-dark); margin-right: 1rem; }
    .overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 40; }
    .overlay.show { display: block; }

</style>
