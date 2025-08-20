@extends('adminlte::page')

@section('title', 'Configurações')

@section('content_header')

@stop

@section('content')
<div class="container-fluid">
    <div class="fi-page-header">
        <div>
            <h1 class="fi-title">Configurações</h1>
            <p class="fi-subtitle">Gerencie as preferências do sistema e cadastros essenciais.</p>
        </div>
    </div>

    <div class="row">
        <!-- Card: Empresas -->
        <div class="col-lg-4 col-md-6 col-12 mb-3">
            <a href="{{ route('empresas.index') }}" class="fi-card-link-wrap">
                <div class="fi-card" style="--accent: var(--fi-orange);">
                    <div class="fi-card-icon"><i class="fas fa-building"></i></div>
                    <div class="fi-card-content">
                        <h3>Empresas</h3>
                        <p>Cadastro de empresas, dados fiscais e parâmetros.</p>
                        <span class="fi-card-cta">Abrir <i class="fas fa-arrow-right"></i></span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card: Preferências (exemplo/placeholder) -->
        <div class="col-lg-4 col-md-6 col-12 mb-3">
            <div class="fi-card" style="--accent: var(--fi-blue); opacity:.75; cursor:not-allowed;">
                <div class="fi-card-icon"><i class="fas fa-sliders-h"></i></div>
                <div class="fi-card-content">
                    <h3>Preferências</h3>
                    <p>Configurações gerais do sistema (em breve).</p>
                    <span class="fi-card-cta">Indisponível</span>
                </div>
            </div>
        </div>

        <!-- Card: Usuários (exemplo/placeholder) -->
        <div class="col-lg-4 col-md-6 col-12 mb-3">
            <div class="fi-card" style="--accent: var(--fi-dark); opacity:.75; cursor:not-allowed;">
                <div class="fi-card-icon"><i class="fas fa-users-cog"></i></div>
                <div class="fi-card-content">
                    <h3>Usuários & Permissões</h3>
                    <p>Controle de acesso e papéis (em breve).</p>
                    <span class="fi-card-cta">Indisponível</span>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    :root{
        --fi-orange:#FF6B1A;
        --fi-dark:#111111;
        --fi-gray:#6B7280;
        --fi-gray-100:#F3F4F6;
        --fi-white:#FFFFFF;
        --fi-blue:#2563EB;
    }

    .fi-page-header{
        display:flex; align-items:center; justify-content:space-between;
        padding: 6px 2px 14px;
        margin-bottom: 10px;
        border-bottom:1px solid var(--fi-gray-100);
    }
    .fi-title{
        margin:0; font-weight:800; color:var(--fi-dark); font-size:26px; line-height:1.1;
    }
    .fi-subtitle{
        margin:6px 0 0; color:var(--fi-gray); font-size:14px;
    }

    .fi-card{
        position: relative;
        display:flex;
        gap: 12px;
        align-items: center;
        background: var(--fi-white);
        border:1px solid var(--fi-gray-100);
        border-left:6px solid var(--accent, var(--fi-orange));
        border-radius:12px;
        padding:18px 16px;
        box-shadow: 0 4px 14px rgba(17,17,17,0.06);
        transition: transform .15s ease, box-shadow .15s ease;
        min-height: 110px;
    }
    .fi-card:hover{
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(17,17,17,0.10);
    }
    .fi-card-icon{
        flex: 0 0 auto;
        width: 48px; height: 48px;
        border-radius: 10px;
        display:flex; align-items:center; justify-content:center;
        background: linear-gradient(140deg, var(--accent, var(--fi-orange)) 0%, rgba(0,0,0,0.0) 100%);
        color: var(--fi-white);
    }
    .fi-card-icon i{ font-size: 22px; }
    .fi-card-content h3{
        margin:0;
        font-size: 20px;
        color: var(--fi-dark);
        line-height: 1.2;
        font-weight: 800;
    }
    .fi-card-content p{
        margin:4px 0 10px;
        color: var(--fi-gray);
        font-size: 13px;
    }
    .fi-card-cta{
        font-size: 13px;
        font-weight: 700;
        color: var(--accent, var(--fi-orange));
    }
    .fi-card-link-wrap{
        text-decoration:none;
    }
</style>
@stop

@section('js')

@stop
