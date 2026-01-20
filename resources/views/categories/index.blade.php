@extends('layouts.app')

@section('title', 'Liste des catégories')

@section('content')

<style>
    /* ======================== HEADER SECTION ======================== */
    .categories-header {
        background: linear-gradient(135deg, #8B6F47 0%, #5D4E37 100%);
        color: white;
        padding: 3rem 2rem;
        border-radius: 15px;
        margin-bottom: 3rem;
        box-shadow: 0 10px 30px rgba(93, 78, 55, 0.2);
    }

    .categories-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 2rem;
    }

    .categories-header-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
    }

    .categories-header-subtitle {
        font-size: 1rem;
        opacity: 0.9;
        margin: 0.5rem 0 0 0;
    }

    .categories-header-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1.5rem;
        background: white;
        color: #8B6F47;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-action:hover {
        background: #FFD700;
        color: #5D4E37;
        transform: translateY(-2px);
    }

    /* ======================== CATEGORIES TABLE ======================== */
    .categories-table-container {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(93, 78, 55, 0.08);
        margin-bottom: 3rem;
    }

    .categories-table {
        width: 100%;
        border-collapse: collapse;
    }

    .categories-table thead {
        background: #F5F1ED;
        border-bottom: 2px solid #D4A574;
    }

    .categories-table th {
        padding: 1.25rem;
        text-align: left;
        font-weight: 700;
        color: #5D4E37;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .categories-table tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: background 0.3s ease;
    }

    .categories-table tbody tr:hover {
        background: #FFFBF7;
    }

    .categories-table td {
        padding: 1.25rem;
        color: #555;
    }

    .category-name {
        font-weight: 600;
        color: #5D4E37;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .category-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #D4A574 0%, #FFD700 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
    }

    .category-description {
        font-size: 0.95rem;
        color: #666;
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .category-stats {
        display: flex;
        gap: 1.5rem;
        align-items: center;
    }

    .stat-badge {
        display: inline-block;
        background: #F5F1ED;
        color: #8B6F47;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .actions {
        display: flex;
        gap: 0.75rem;
    }

    .btn-small {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 1rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-edit {
        background: #E3F2FD;
        color: #1976D2;
    }

    .btn-edit:hover {
        background: #1976D2;
        color: white;
    }

    .btn-delete {
        background: #FFEBEE;
        color: #C62828;
    }

    .btn-delete:hover {
        background: #C62828;
        color: white;
    }

    /* ======================== EMPTY STATE ======================== */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: linear-gradient(135deg, #F5F1ED 0%, #FFFBF7 100%);
        border-radius: 15px;
        border: 2px dashed #D4A574;
    }

    .empty-state-icon {
        font-size: 3.5rem;
        color: #D4A574;
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        color: #5D4E37;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #888;
        margin-bottom: 2rem;
    }

    /* ======================== RESPONSIVE ======================== */
    @media (max-width: 768px) {
        .categories-header {
            padding: 2rem;
        }

        .categories-header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .categories-header-title {
            font-size: 1.5rem;
        }

        .categories-table {
            font-size: 0.9rem;
        }

        .categories-table th,
        .categories-table td {
            padding: 0.75rem;
        }

        .category-description {
            max-width: 200px;
        }

        .category-stats {
            flex-direction: column;
            gap: 0.5rem;
        }
    }

    @media (max-width: 576px) {
        .categories-header-content {
            flex-direction: column;
            gap: 1.5rem;
        }

        .categories-header-actions {
            width: 100%;
        }

        .btn-action {
            flex: 1;
            justify-content: center;
        }

        .categories-table-container {
            overflow-x: auto;
        }

        .actions {
            gap: 0.5rem;
        }
    }
</style>

<!-- Header Section -->
<div class="categories-header">
    <div class="categories-header-content">
        <div>
            <h1 class="categories-header-title">
                <i class="bi bi-grid-3x3"></i> Catégories
            </h1>
            <p class="categories-header-subtitle">Gérez les catégories de produits</p>
        </div>
        <div class="categories-header-actions">
            <a href="{{ route('admin.categories.create') }}" class="btn-action">
                <i class="bi bi-plus-circle"></i> Nouvelle catégorie
            </a>
        </div>
    </div>
</div>

@if ($categories->isEmpty())
    <!-- Empty State -->
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="bi bi-inbox"></i>
        </div>
        <h3>Aucune catégorie</h3>
        <p>Commencez par créer votre première catégorie.</p>
        <a href="{{ route('admin.categories.create') }}" class="btn-action" style="display: inline-flex;">
            <i class="bi bi-plus-circle"></i> Créer une catégorie
        </a>
    </div>
@else
    <!-- Categories Table -->
    <div class="categories-table-container">
        <table class="categories-table">
            <thead>
                <tr>
                    <th style="width: 25%;">Nom</th>
                    <th style="width: 35%;">Description</th>
                    <th style="width: 20%;">Statistiques</th>
                    <th style="width: 20%;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>
                            <div class="category-name">
                                <div class="category-icon">
                                    {{ strtoupper(substr($category->name, 0, 1)) }}
                                </div>
                                <span>{{ $category->name }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="category-description">
                                {{ $category->description ?? '-' }}
                            </div>
                        </td>
                        <td>
                            <div class="category-stats">
                                <span class="stat-badge">
                                    <i class="bi bi-bag-check"></i>
                                    {{ $category->products_count ?? 0 }} produit{{ ($category->products_count ?? 0) > 1 ? 's' : '' }}
                                </span>
                            </div>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn-small btn-edit" title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-small btn-delete" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

@endsection
