@extends('layouts.app')

@section('title', 'Choose Theme — NyumbaHub')

@section('content')

<div style="max-width:900px;margin:0 auto;">

    <div style="margin-bottom:32px;">
        <h1 style="font-family:var(--font-display,Georgia,serif);font-size:32px;font-weight:700;color:var(--text,#222);margin-bottom:8px;">
            Personalise Your Experience
        </h1>
        <p style="font-size:15px;color:var(--text-muted,#717171);">
            Choose a theme that suits your style. Your preference is saved automatically.
        </p>
    </div>

    <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:24px;margin-bottom:40px;" id="themeGrid">

        {{-- Light Theme --}}
        <div class="theme-option selected" data-theme="light" onclick="selectTheme(this)">
            <div class="theme-preview-box">
                <img src="{{ asset('images/themes/light.jpg') }}" alt="Light Theme">
                <div class="theme-overlay light-overlay">
                    <div class="mini-nav" style="background:rgba(255,255,255,0.95);">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:28px;height:28px;border-radius:50%;background:#1B4332;"></div>
                            <div style="font-size:11px;font-weight:700;color:#1B4332;">Nyumba<span style="color:#D4A853;">Hub</span></div>
                        </div>
                        <div style="display:flex;gap:6px;">
                            <div style="width:40px;height:8px;border-radius:4px;background:#EBEBEB;"></div>
                            <div style="width:28px;height:8px;border-radius:4px;background:#1B4332;"></div>
                        </div>
                    </div>
                    <div class="mini-cards">
                        <div class="mini-card" style="background:rgba(255,255,255,0.95);">
                            <div style="height:40px;background:#E8F4F0;border-radius:6px;margin-bottom:6px;"></div>
                            <div style="height:6px;background:#222;border-radius:3px;margin-bottom:4px;width:80%;"></div>
                            <div style="height:5px;background:#717171;border-radius:3px;width:60%;margin-bottom:6px;"></div>
                            <div style="height:14px;background:#1B4332;border-radius:7px;width:50%;"></div>
                        </div>
                        <div class="mini-card" style="background:rgba(255,255,255,0.95);">
                            <div style="height:40px;background:#FEF3E2;border-radius:6px;margin-bottom:6px;"></div>
                            <div style="height:6px;background:#222;border-radius:3px;margin-bottom:4px;width:70%;"></div>
                            <div style="height:5px;background:#717171;border-radius:3px;width:50%;margin-bottom:6px;"></div>
                            <div style="height:14px;background:#D4A853;border-radius:7px;width:50%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="theme-label">
                <div style="display:flex;align-items:center;justify-content:space-between;">
                    <div>
                        <div style="font-size:15px;font-weight:700;color:var(--text,#222);">Light</div>
                        <div style="font-size:12px;color:var(--text-muted,#717171);margin-top:2px;">Clean white surfaces</div>
                    </div>
                    <div class="theme-radio active" id="radio-light"></div>
                </div>
            </div>
        </div>

        {{-- Dark Theme --}}
        <div class="theme-option" data-theme="dark" onclick="selectTheme(this)">
            <div class="theme-preview-box">
                <img src="{{ asset('images/themes/dark.jpg') }}" alt="Dark Theme">
                <div class="theme-overlay dark-overlay">
                    <div class="mini-nav" style="background:rgba(17,17,17,0.97);">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:28px;height:28px;border-radius:50%;background:#D4A853;"></div>
                            <div style="font-size:11px;font-weight:700;color:#fff;">Nyumba<span style="color:#D4A853;">Hub</span></div>
                        </div>
                        <div style="display:flex;gap:6px;">
                            <div style="width:40px;height:8px;border-radius:4px;background:#333;"></div>
                            <div style="width:28px;height:8px;border-radius:4px;background:#D4A853;"></div>
                        </div>
                    </div>
                    <div class="mini-cards">
                        <div class="mini-card" style="background:rgba(30,30,30,0.97);border:1px solid #333;">
                            <div style="height:40px;background:#1B4332;border-radius:6px;margin-bottom:6px;"></div>
                            <div style="height:6px;background:#fff;border-radius:3px;margin-bottom:4px;width:80%;"></div>
                            <div style="height:5px;background:#888;border-radius:3px;width:60%;margin-bottom:6px;"></div>
                            <div style="height:14px;background:#D4A853;border-radius:7px;width:50%;"></div>
                        </div>
                        <div class="mini-card" style="background:rgba(30,30,30,0.97);border:1px solid #333;">
                            <div style="height:40px;background:#2D6A4F;border-radius:6px;margin-bottom:6px;"></div>
                            <div style="height:6px;background:#fff;border-radius:3px;margin-bottom:4px;width:70%;"></div>
                            <div style="height:5px;background:#888;border-radius:3px;width:50%;margin-bottom:6px;"></div>
                            <div style="height:14px;background:#1B4332;border-radius:7px;width:50%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="theme-label">
                <div style="display:flex;align-items:center;justify-content:space-between;">
                    <div>
                        <div style="font-size:15px;font-weight:700;color:var(--text,#222);">Dark</div>
                        <div style="font-size:12px;color:var(--text-muted,#717171);margin-top:2px;">Easy on the eyes at night</div>
                    </div>
                    <div class="theme-radio" id="radio-dark"></div>
                </div>
            </div>
        </div>

        {{-- Green Theme --}}
        <div class="theme-option" data-theme="green" onclick="selectTheme(this)">
            <div class="theme-preview-box">
                <img src="{{ asset('images/themes/green.jpg') }}" alt="Green Theme">
                <div class="theme-overlay green-overlay">
                    <div class="mini-nav" style="background:rgba(27,67,50,0.97);">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:28px;height:28px;border-radius:50%;background:#D4A853;"></div>
                            <div style="font-size:11px;font-weight:700;color:#fff;">Nyumba<span style="color:#D4A853;">Hub</span></div>
                        </div>
                        <div style="display:flex;gap:6px;">
                            <div style="width:40px;height:8px;border-radius:4px;background:rgba(255,255,255,0.2);"></div>
                            <div style="width:28px;height:8px;border-radius:4px;background:#D4A853;"></div>
                        </div>
                    </div>
                    <div class="mini-cards">
                        <div class="mini-card" style="background:rgba(232,244,240,0.97);border:1px solid #C8E6DC;">
                            <div style="height:40px;background:#1B4332;border-radius:6px;margin-bottom:6px;"></div>
                            <div style="height:6px;background:#1B4332;border-radius:3px;margin-bottom:4px;width:80%;"></div>
                            <div style="height:5px;background:#2D6A4F;border-radius:3px;width:60%;margin-bottom:6px;"></div>
                            <div style="height:14px;background:#1B4332;border-radius:7px;width:50%;"></div>
                        </div>
                        <div class="mini-card" style="background:rgba(232,244,240,0.97);border:1px solid #C8E6DC;">
                            <div style="height:40px;background:#2D6A4F;border-radius:6px;margin-bottom:6px;"></div>
                            <div style="height:6px;background:#1B4332;border-radius:3px;margin-bottom:4px;width:70%;"></div>
                            <div style="height:5px;background:#2D6A4F;border-radius:3px;width:50%;margin-bottom:6px;"></div>
                            <div style="height:14px;background:#D4A853;border-radius:7px;width:50%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="theme-label">
                <div style="display:flex;align-items:center;justify-content:space-between;">
                    <div>
                        <div style="font-size:15px;font-weight:700;color:var(--text,#222);">Green</div>
                        <div style="font-size:12px;color:var(--text-muted,#717171);margin-top:2px;">NyumbaHub signature</div>
                    </div>
                    <div class="theme-radio" id="radio-green"></div>
                </div>
            </div>
        </div>

        {{-- Gold Theme --}}
        <div class="theme-option" data-theme="gold" onclick="selectTheme(this)">
            <div class="theme-preview-box">
                <img src="{{ asset('images/themes/gold.jpg') }}" alt="Gold Theme">
                <div class="theme-overlay gold-overlay">
                    <div class="mini-nav" style="background:rgba(15,45,31,0.97);">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:28px;height:28px;border-radius:50%;background:#D4A853;"></div>
                            <div style="font-size:11px;font-weight:700;color:#D4A853;">Nyumba<span style="color:#fff;">Hub</span></div>
                        </div>
                        <div style="display:flex;gap:6px;">
                            <div style="width:40px;height:8px;border-radius:4px;background:rgba(212,168,83,0.3);"></div>
                            <div style="width:28px;height:8px;border-radius:4px;background:#D4A853;"></div>
                        </div>
                    </div>
                    <div class="mini-cards">
                        <div class="mini-card" style="background:rgba(251,245,230,0.97);border:1px solid #F0DCA0;">
                            <div style="height:40px;background:#D4A853;border-radius:6px;margin-bottom:6px;"></div>
                            <div style="height:6px;background:#0F2D1F;border-radius:3px;margin-bottom:4px;width:80%;"></div>
                            <div style="height:5px;background:#B8922E;border-radius:3px;width:60%;margin-bottom:6px;"></div>
                            <div style="height:14px;background:#D4A853;border-radius:7px;width:50%;"></div>
                        </div>
                        <div class="mini-card" style="background:rgba(251,245,230,0.97);border:1px solid #F0DCA0;">
                            <div style="height:40px;background:#E8C47A;border-radius:6px;margin-bottom:6px;"></div>
                            <div style="height:6px;background:#0F2D1F;border-radius:3px;margin-bottom:4px;width:70%;"></div>
                            <div style="height:5px;background:#B8922E;border-radius:3px;width:50%;margin-bottom:6px;"></div>
                            <div style="height:14px;background:#1B4332;border-radius:7px;width:50%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="theme-label">
                <div style="display:flex;align-items:center;justify-content:space-between;">
                    <div>
                        <div style="font-size:15px;font-weight:700;color:var(--text,#222);">Gold</div>
                        <div style="font-size:12px;color:var(--text-muted,#717171);margin-top:2px;">Premium warm luxury</div>
                    </div>
                    <div class="theme-radio" id="radio-gold"></div>
                </div>
            </div>
        </div>

    </div>

    {{-- Apply button --}}
    <div style="display:flex;gap:12px;align-items:center;">
        <button onclick="applyTheme()" class="btn-primary" style="padding:14px 40px;font-size:15px;">
            <i class="fa-solid fa-palette"></i> Apply Theme
        </button>
        <span id="theme-msg" style="font-size:14px;color:#2D6A4F;display:none;">
            <i class="fa-solid fa-circle-check"></i> Theme applied!
        </span>
    </div>

</div>

@endsection

@push('styles')
<style>
.theme-option {
    border: 2px solid #EBEBEB;
    border-radius: 16px;
    overflow: hidden;
    cursor: pointer;
    transition: border-color 0.2s, transform 0.2s, box-shadow 0.2s;
    background: #fff;
}

.theme-option:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    border-color: #DDDDDD;
}

.theme-option.selected {
    border-color: #1B4332;
    box-shadow: 0 0 0 3px rgba(27,67,50,0.15);
}

.theme-preview-box {
    position: relative;
    height: 180px;
    overflow: hidden;
}

.theme-preview-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.theme-option:hover .theme-preview-box img {
    transform: scale(1.05);
}

.theme-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding: 0;
}

.light-overlay { background: rgba(247,247,247,0.35); }
.dark-overlay  { background: rgba(0,0,0,0.45); }
.green-overlay { background: rgba(27,67,50,0.35); }
.gold-overlay  { background: rgba(15,45,31,0.4); }

.mini-nav {
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 12px;
    backdrop-filter: blur(4px);
}

.mini-cards {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
    padding: 8px 12px;
    flex: 1;
}

.mini-card {
    border-radius: 8px;
    padding: 8px;
    backdrop-filter: blur(4px);
}

.theme-label {
    padding: 14px 16px;
    border-top: 1px solid #EBEBEB;
}

.theme-radio {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid #DDDDDD;
    flex-shrink: 0;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.theme-radio.active {
    border-color: #1B4332;
    background: #1B4332;
}

.theme-radio.active::after {
    content: '';
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: white;
}
</style>
@endpush

@push('scripts')
<script>
const themes = {
    light: {
        '--bg': '#FFFFFF',
        '--bg-soft': '#F7F7F7',
        '--text': '#222222',
        '--text-muted': '#717171',
        '--border': '#DDDDDD',
        '--border-light': '#EBEBEB',
        '--primary': '#1B4332',
        '--primary-light': '#2D6A4F',
        '--primary-dark': '#0F2D1F',
        '--accent': '#D4A853',
        '--nav-bg': '#FFFFFF',
        '--nav-text': '#222222',
        '--card-bg': '#FFFFFF',
    },
    dark: {
        '--bg': '#111111',
        '--bg-soft': '#1A1A1A',
        '--text': '#F5F5F5',
        '--text-muted': '#888888',
        '--border': '#333333',
        '--border-light': '#2A2A2A',
        '--primary': '#D4A853',
        '--primary-light': '#E8C47A',
        '--primary-dark': '#B8922E',
        '--accent': '#1B4332',
        '--nav-bg': '#111111',
        '--nav-text': '#F5F5F5',
        '--card-bg': '#1E1E1E',
    },
    green: {
        '--bg': '#E8F4F0',
        '--bg-soft': '#D5EDE5',
        '--text': '#0F2D1F',
        '--text-muted': '#2D6A4F',
        '--border': '#C8E6DC',
        '--border-light': '#D5EDE5',
        '--primary': '#1B4332',
        '--primary-light': '#2D6A4F',
        '--primary-dark': '#0F2D1F',
        '--accent': '#D4A853',
        '--nav-bg': '#1B4332',
        '--nav-text': '#FFFFFF',
        '--card-bg': '#FFFFFF',
    },
    gold: {
        '--bg': '#FBF5E6',
        '--bg-soft': '#F5EDD0',
        '--text': '#0F2D1F',
        '--text-muted': '#8B6914',
        '--border': '#F0DCA0',
        '--border-light': '#F5EDD0',
        '--primary': '#D4A853',
        '--primary-light': '#E8C47A',
        '--primary-dark': '#B8922E',
        '--accent': '#1B4332',
        '--nav-bg': '#0F2D1F',
        '--nav-text': '#D4A853',
        '--card-bg': '#FFFFFF',
    }
};

let selectedTheme = localStorage.getItem('nyumbahub-theme') || 'light';

// Show saved theme on load
document.addEventListener('DOMContentLoaded', () => {
    const saved = document.querySelector(`[data-theme="${selectedTheme}"]`);
    if (saved) {
        document.querySelectorAll('.theme-option').forEach(o => o.classList.remove('selected'));
        document.querySelectorAll('.theme-radio').forEach(r => { r.classList.remove('active'); r.innerHTML = ''; });
        saved.classList.add('selected');
        document.getElementById('radio-' + selectedTheme).classList.add('active');
    }
});

function selectTheme(card) {
    document.querySelectorAll('.theme-option').forEach(o => o.classList.remove('selected'));
    document.querySelectorAll('.theme-radio').forEach(r => { r.classList.remove('active'); r.innerHTML = ''; });
    card.classList.add('selected');
    selectedTheme = card.dataset.theme;
    const radio = document.getElementById('radio-' + selectedTheme);
    radio.classList.add('active');
}

function applyTheme() {
    const vars = themes[selectedTheme];
    Object.entries(vars).forEach(([key, value]) => {
        document.documentElement.style.setProperty(key, value);
    });
    localStorage.setItem('nyumbahub-theme', selectedTheme);
    const msg = document.getElementById('theme-msg');
    msg.style.display = 'inline-flex';
    setTimeout(() => msg.style.display = 'none', 3000);
}
</script>
@endpush
