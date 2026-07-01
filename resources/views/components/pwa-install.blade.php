<div id="pwa-install-banner" class="pwa-banner" style="display: none;">
    <div class="pwa-banner-content">
        <div class="pwa-icon">
            <img src="{{ asset('images/nyumbahublogo.png') }}" alt="NyumbaHub Logo">
        </div>
        <div class="pwa-text">
            <strong>Install NyumbaHub</strong>
            <p>Get a faster, app-like experience with offline access.</p>
        </div>
    </div>
    <div class="pwa-actions">
        <button onclick="dismissPWA()" class="pwa-btn-text">{{ __('Not Now') }}</button>
        <button onclick="installPWA()" class="pwa-btn-primary">{{ __('Install App') }}</button>
    </div>
</div>

<style>
.pwa-banner {
    position: fixed;
    bottom: 24px;
    left: 24px;
    right: 24px;
    background: var(--surface, #FFFFFF);
    border: 1px solid var(--border-light, #EBEBEB);
    box-shadow: 0 12px 32px rgba(0,0,0,0.15);
    border-radius: 16px;
    padding: 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    z-index: 9999;
    max-width: 600px;
    margin: 0 auto;
    animation: slideUp 0.4s ease-out;
}
.pwa-banner-content {
    display: flex;
    align-items: center;
    gap: 16px;
}
.pwa-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    overflow: hidden;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.pwa-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.pwa-text strong {
    display: block;
    font-size: 15px;
    color: var(--text, #222);
    margin-bottom: 4px;
}
.pwa-text p {
    margin: 0;
    font-size: 13px;
    color: var(--text-muted, #717171);
}
.pwa-actions {
    display: flex;
    align-items: center;
    gap: 12px;
}
.pwa-btn-text {
    background: transparent;
    border: none;
    color: var(--text-muted, #717171);
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    padding: 8px;
}
.pwa-btn-primary {
    background: var(--primary, #1B4332);
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 8px 16px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s;
}
.pwa-btn-primary:hover {
    background: #0f2d1f;
}

@keyframes slideUp {
    from { transform: translateY(100px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

@media (max-width: 600px) {
    .pwa-banner {
        flex-direction: column;
        align-items: stretch;
        gap: 16px;
        bottom: 16px;
        left: 16px;
        right: 16px;
    }
    .pwa-actions {
        justify-content: flex-end;
    }
}
</style>
