<?php // 此文件无PHP逻辑，仅为方便统一部署使用.php后缀 ?>
<!DOCTYPE html>
<html lang="zh-CN" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>时间胶囊 | Time Capsule</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Noto+Serif+SC:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --bg:#07080d;--bg-alt:#0d0e16;--card:#11121c;--card-hover:#181a28;
            --border:rgba(196,164,66,.13);--border-strong:rgba(196,164,66,.35);
            --accent:#c4a442;--accent-dim:#9a7f30;--accent-glow:rgba(196,164,66,.22);
            --text:#ece6d8;--text-secondary:#b0a898;--text-muted:#6d665c;
            --input-bg:#0a0b13;--error:#d44;
        }
        [data-theme="light"]{
            --bg:#f2ecde;--bg-alt:#e8e1d0;--card:#fff;--card-hover:#faf6ee;
            --border:rgba(139,105,20,.16);--border-strong:rgba(139,105,20,.4);
            --accent:#8b6914;--accent-dim:#6d5310;--accent-glow:rgba(139,105,20,.1);
            --text:#1a1814;--text-secondary:#4a4438;--text-muted:#8a8275;
            --input-bg:#f7f3e9;--error:#b33;
        }
        *,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Noto Serif SC',Georgia,serif;background:var(--bg);color:var(--text);min-height:100vh;overflow-x:hidden;transition:background .5s,color .5s}
        .font-display{font-family:'Cinzel','Noto Serif SC',serif}
        #particle-cv{position:fixed;inset:0;z-index:0;pointer-events:none}
        .bg-orb{position:fixed;border-radius:50%;filter:blur(120px);opacity:.12;pointer-events:none;z-index:0;transition:opacity .5s}
        [data-theme="light"] .bg-orb{opacity:.07}
        .page{display:none;position:relative;z-index:1;min-height:100vh}
        .page.active{display:flex;flex-direction:column;animation:pageIn .55s ease both}
        @keyframes pageIn{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)}}
        .title-shimmer{background:linear-gradient(90deg,var(--accent),#e8d48b,var(--accent));background-size:200% 100%;-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;animation:shimmer 4s ease-in-out infinite}
        @keyframes shimmer{0%,100%{background-position:0% 50%}50%{background-position:100% 50%}}
        .id-card{background:var(--card);border:1px solid var(--border);border-radius:18px;padding:2.8rem 1.8rem 2.4rem;cursor:pointer;transition:all .4s cubic-bezier(.23,1,.32,1);position:relative;overflow:hidden}
        .id-card::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse at 50% -20%,var(--accent-glow),transparent 70%);opacity:0;transition:opacity .4s}
        .id-card:hover,.id-card:focus-visible{border-color:var(--accent);transform:translateY(-6px);box-shadow:0 12px 40px var(--accent-glow)}
        .id-card:hover::before,.id-card:focus-visible::before{opacity:1}
        .fi{width:100%;background:var(--input-bg);border:1px solid var(--border);border-radius:10px;padding:.85rem 1rem;color:var(--text);font-family:'Noto Serif SC',serif;font-size:.95rem;transition:all .3s;outline:none;resize:vertical}
        .fi:focus{border-color:var(--accent);box-shadow:0 0 0 3px var(--accent-glow)}
        .fi::placeholder{color:var(--text-muted)}
        textarea.fi{min-height:96px;line-height:1.75}
        .q-num{display:inline-flex;align-items:center;justify-content:center;width:26px;height:26px;border-radius:50%;background:var(--accent);color:var(--bg);font-weight:700;font-size:.75rem;flex-shrink:0}
        .btn-p{background:var(--accent);color:var(--bg);border:none;padding:.85rem 2.4rem;border-radius:10px;font-family:'Noto Serif SC',serif;font-weight:600;font-size:.95rem;cursor:pointer;transition:all .3s;position:relative}
        .btn-p:hover{filter:brightness(1.12);box-shadow:0 4px 24px var(--accent-glow);transform:translateY(-1px)}
        .btn-p:active{transform:translateY(0)}
        .btn-p:disabled{opacity:.55;cursor:not-allowed;transform:none;filter:none;box-shadow:none}
        .btn-s{background:transparent;color:var(--text-secondary);border:1px solid var(--border);padding:.85rem 2rem;border-radius:10px;font-family:'Noto Serif SC',serif;font-size:.95rem;cursor:pointer;transition:all .3s}
        .btn-s:hover{border-color:var(--text-secondary);color:var(--text)}
        .divider{height:1px;margin:2rem 0;background:linear-gradient(to right,transparent,var(--border-strong),transparent)}
        .letter{background:var(--card);border:1px solid var(--border);border-radius:18px;padding:2.5rem;position:relative;overflow:hidden}
        .letter::before{content:'';position:absolute;top:0;right:0;width:60px;height:60px;background:linear-gradient(135deg,transparent 50%,var(--accent-glow) 50%)}
        .capsule{width:110px;height:110px;border-radius:50%;background:radial-gradient(circle at 38% 38%,#e8d48b,var(--accent),var(--accent-dim));display:flex;align-items:center;justify-content:center;font-size:2.6rem;color:var(--bg);position:relative;animation:capPulse 2.4s ease-in-out infinite}
        .capsule::after{content:'';position:absolute;inset:-10px;border-radius:50%;border:2px solid var(--accent);opacity:.3;animation:capRing 2.4s ease-in-out infinite}
        @keyframes capPulse{0%,100%{box-shadow:0 0 30px var(--accent-glow)}50%{box-shadow:0 0 60px var(--accent-glow),0 0 100px rgba(196,164,66,.08)}}
        @keyframes capRing{0%,100%{transform:scale(1);opacity:.3}50%{transform:scale(1.18);opacity:.08}}
        .seal-anim{animation:sealDrop .9s cubic-bezier(.23,1,.32,1) both}
        @keyframes sealDrop{from{opacity:0;transform:scale(.2) rotateY(180deg)}to{opacity:1;transform:scale(1) rotateY(0)}}
        .countdown-num{font-family:'Cinzel',serif;font-weight:700;font-size:2rem;color:var(--accent);line-height:1}
        .countdown-label{font-size:.7rem;color:var(--text-muted);margin-top:2px}
        .toast-bar{position:fixed;bottom:2rem;left:50%;transform:translateX(-50%) translateY(100px);background:var(--card);border:1px solid var(--border);padding:.8rem 1.5rem;border-radius:10px;font-size:.88rem;z-index:200;opacity:0;transition:all .4s cubic-bezier(.23,1,.32,1);box-shadow:0 10px 30px rgba(0,0,0,.25)}
        .toast-bar.show{opacity:1;transform:translateX(-50%) translateY(0)}
        .toast-bar.err{border-color:var(--error);color:var(--error)}
        .theme-btn{position:fixed;top:1.4rem;right:1.4rem;z-index:100;width:42px;height:42px;border-radius:50%;border:1px solid var(--border-strong);background:var(--card);color:var(--accent);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:1rem;transition:all .3s;backdrop-filter:blur(6px)}
        .theme-btn:hover{background:var(--card-hover);border-color:var(--accent);box-shadow:0 0 14px var(--accent-glow)}
        .q-block{opacity:0;transform:translateY(14px);animation:qIn .5s ease forwards}
        @keyframes qIn{to{opacity:1;transform:translateY(0)}}
        @media(max-width:640px){.id-grid{grid-template-columns:1fr!important}.capsule{width:88px;height:88px;font-size:2rem}.countdown-num{font-size:1.5rem}}
        @media(prefers-reduced-motion:reduce){*,*::before,*::after{animation-duration:.01ms!important;transition-duration:.01ms!important}}
        ::-webkit-scrollbar{width:5px}::-webkit-scrollbar-track{background:var(--bg)}::-webkit-scrollbar-thumb{background:var(--border-strong);border-radius:3px}

        /* 加载旋转 */
        .spin{display:inline-block;animation:spin 1s linear infinite}
        @keyframes spin{to{transform:rotate(360deg)}}
    </style>
</head>
<body>

<canvas id="particle-cv"></canvas>
<div class="bg-orb" style="width:500px;height:500px;top:-160px;left:-160px;background:var(--accent);"></div>
<div class="bg-orb" style="width:400px;height:400px;bottom:-120px;right:-120px;background:var(--accent);opacity:.06;"></div>

<button class="theme-btn" onclick="toggleTheme()" aria-label="切换主题">
    <i class="fas fa-moon" id="theme-ico"></i>
</button>

<div class="toast-bar" id="toast-el"></div>

<main>

    <!-- ====== LANDING ====== -->
    <section id="pg-landing" class="page active items-center justify-center px-4">
        <div class="text-center max-w-3xl mx-auto">
            <div class="mb-5" style="color:var(--accent);font-size:1.8rem;"><i class="fas fa-hourglass-half"></i></div>
            <h1 class="font-display title-shimmer text-5xl sm:text-7xl font-bold tracking-widest mb-4" style="letter-spacing:.16em;">TIME CAPSULE</h1>
            <p class="text-lg sm:text-xl mb-1" style="color:var(--text-secondary);">将此刻的期许封存，一年后由时光送达</p>
            <p class="text-sm mb-14" style="color:var(--text-muted);">选择你的身份，开始书写寄往未来的信</p>
            <div class="id-grid grid grid-cols-2 gap-6 max-w-xl mx-auto">
                <div class="id-card" onclick="pick('student')" role="button" tabindex="0" aria-label="我是学生">
                    <div class="relative z-10">
                        <div class="mb-4" style="color:var(--accent);font-size:2.4rem;"><i class="fas fa-graduation-cap"></i></div>
                        <h2 class="font-display text-xl font-bold mb-2">学生</h2>
                        <p class="text-sm leading-relaxed" style="color:var(--text-muted);">写下你的梦想与期许<br>给一年后的自己</p>
                    </div>
                </div>
                <div class="id-card" onclick="pick('parent')" role="button" tabindex="0" aria-label="我是家长">
                    <div class="relative z-10">
                        <div class="mb-4" style="color:var(--accent);font-size:2.4rem;"><i class="fas fa-hands-holding-child"></i></div>
                        <h2 class="font-display text-xl font-bold mb-2">家长</h2>
                        <p class="text-sm leading-relaxed" style="color:var(--text-muted);">写下对孩子的祝福与期待<br>给未来的一封信</p>
                    </div>
                </div>
            </div>
            <p class="mt-14 text-xs" style="color:var(--text-muted);"><i class="fas fa-lock mr-1"></i> 你的回答仅用于一年后寄送，不会公开展示</p>
        </div>
    </section>

    <!-- ====== FORM ====== -->
    <section id="pg-form" class="page items-center px-4 py-14">
        <div class="w-full max-w-2xl mx-auto">
            <div class="flex items-center gap-3 mb-2 flex-wrap">
                <button onclick="nav('landing')" class="btn-s" style="padding:.45rem .9rem;font-size:.82rem;"><i class="fas fa-arrow-left mr-1"></i>返回</button>
                <span id="f-badge" class="text-xs px-3 py-1 rounded-full" style="background:var(--accent-glow);color:var(--accent);border:1px solid var(--border);"></span>
            </div>
            <h2 class="font-display text-3xl font-bold mb-1" style="color:var(--accent);" id="f-title"></h2>
            <p class="text-sm mb-6" style="color:var(--text-muted);" id="f-sub"></p>
            <div class="divider"></div>
            <div class="space-y-5 mb-8">
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color:var(--text-secondary);"><i class="fas fa-user mr-1" style="color:var(--accent);"></i> 姓名</label>
                    <input type="text" id="inp-name" class="fi" placeholder="请输入你的姓名" maxlength="20">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color:var(--text-secondary);"><i class="fas fa-envelope mr-1" style="color:var(--accent);"></i> 邮箱</label>
                    <input type="email" id="inp-email" class="fi" placeholder="一年后，时光胶囊将寄到这里">
                </div>
            </div>
            <div class="divider"></div>
            <div id="q-wrap" class="space-y-8 mb-10"></div>
            <div class="divider"></div>
            <div class="flex justify-center gap-4 pb-8">
                <button onclick="nav('landing')" class="btn-s">取消</button>
                <button onclick="submitForm()" class="btn-p" id="btn-preview"><i class="fas fa-scroll mr-2"></i>预览并封存</button>
            </div>
        </div>
    </section>

    <!-- ====== PREVIEW ====== -->
    <section id="pg-preview" class="page items-center px-4 py-14">
        <div class="w-full max-w-2xl mx-auto">
            <h2 class="font-display text-3xl font-bold mb-1 text-center" style="color:var(--accent);">预览你的时间胶囊</h2>
            <p class="text-sm mb-8 text-center" style="color:var(--text-muted);">确认内容无误后，封存至一年后</p>
            <div class="letter">
                <div class="text-center mb-5">
                    <div class="font-display text-base tracking-widest" style="color:var(--accent);letter-spacing:.12em;">TIME CAPSULE</div>
                    <div class="text-xs mt-1" style="color:var(--text-muted);" id="pv-role"></div>
                    <div class="font-display text-xl font-bold mt-2" id="pv-name"></div>
                </div>
                <div class="divider" style="margin:1.4rem 0;"></div>
                <div id="pv-qs" class="space-y-5"></div>
                <div class="divider" style="margin:1.4rem 0;"></div>
                <div class="text-center text-xs" style="color:var(--text-muted);line-height:1.9;">
                    <i class="fas fa-lock mr-1"></i>封存：<span id="pv-seal"></span><br>
                    <i class="fas fa-envelope-open mr-1"></i>开启：<span id="pv-open"></span>
                </div>
            </div>
            <div class="flex justify-center gap-4 mt-8">
                <button onclick="nav('form')" class="btn-s"><i class="fas fa-pen mr-1"></i>修改</button>
                <button onclick="doSeal()" class="btn-p" id="btn-seal"><i class="fas fa-lock mr-2"></i>确认封存</button>
            </div>
        </div>
    </section>

    <!-- ====== SUCCESS ====== -->
    <section id="pg-success" class="page items-center justify-center px-4">
        <div class="text-center max-w-lg mx-auto">
            <div class="capsule seal-anim mx-auto mb-8"><i class="fas fa-lock"></i></div>
            <h2 class="font-display text-2xl sm:text-3xl font-bold mb-2" style="color:var(--accent);" id="s-title"></h2>
            <p class="text-lg mb-1">时间胶囊已封存</p>
            <p class="text-sm mb-8" style="color:var(--text-muted);">一年后的今天，这封胶囊将通过邮箱送达</p>
            <div class="flex justify-center gap-5 mb-10" id="countdown-wrap">
                <div class="text-center"><div class="countdown-num" id="cd-d">--</div><div class="countdown-label">天</div></div>
                <div class="text-center"><div class="countdown-num" id="cd-h">--</div><div class="countdown-label">时</div></div>
                <div class="text-center"><div class="countdown-num" id="cd-m">--</div><div class="countdown-label">分</div></div>
                <div class="text-center"><div class="countdown-num" id="cd-s">--</div><div class="countdown-label">秒</div></div>
            </div>
            <div class="letter text-left inline-block mb-10" style="min-width:260px;padding:1.5rem 2rem;">
                <div class="space-y-2 text-sm">
                    <div style="color:var(--text-muted);"><i class="fas fa-user mr-2" style="color:var(--accent);"></i>姓名：<span style="color:var(--text);" id="s-name"></span></div>
                    <div style="color:var(--text-muted);"><i class="fas fa-envelope mr-2" style="color:var(--accent);"></i>邮箱：<span style="color:var(--text);" id="s-email"></span></div>
                    <div style="color:var(--text-muted);"><i class="fas fa-lock mr-2" style="color:var(--accent);"></i>封存：<span style="color:var(--text);" id="s-seal"></span></div>
                    <div style="color:var(--text-muted);"><i class="fas fa-envelope-open mr-2" style="color:var(--accent);"></i>开启：<span style="color:var(--text);" id="s-open"></span></div>
                </div>
            </div>
            <div><button onclick="reset()" class="btn-p"><i class="fas fa-plus mr-2"></i>创建新的时间胶囊</button></div>
        </div>
    </section>

    <!-- ====== ERROR ====== -->
    <section id="pg-error" class="page items-center justify-center px-4">
        <div class="text-center max-w-md mx-auto">
            <div class="mb-6" style="font-size:3rem;color:var(--error);"><i class="fas fa-exclamation-circle"></i></div>
            <h2 class="text-2xl font-bold mb-3">封存失败</h2>
            <p class="text-sm mb-8" style="color:var(--text-muted);" id="err-msg">服务器开小差了，请稍后重试</p>
            <button onclick="nav('preview')" class="btn-p"><i class="fas fa-redo mr-2"></i>重新尝试</button>
        </div>
    </section>

</main>

<script>
/* ========== 状态 & 问题配置 ========== */
const S = { identity:'', name:'', email:'', answers:{}, openDate:null };

const QS = {
    student: [
        { id:'q1', label:'Dream School', ph:'你梦想中的学校是哪里？', icon:'fa-school' },
        { id:'q2', label:'如果你实现了，奖励自己什么', ph:'想象一下实现梦想的那一刻，你会如何犒赏自己？', icon:'fa-gift' },
        { id:'q3', label:'失败了，想和自己说什么', ph:'如果结果不如预期，你想对那时的自己说些什么？', icon:'fa-heart' },
        { id:'q4', label:'后悔什么', ph:'此刻的你，有什么不愿留下遗憾的事？', icon:'fa-rotate-left' },
        { id:'q5', label:'Message to other students / parents', ph:'想对其他同学和家长说些什么？', icon:'fa-comment-dots' }
    ],
    parent: [
        { id:'q1', label:'孩子毕业之后如何奖励他', ph:'当孩子完成这一段旅程，你打算怎样庆祝？', icon:'fa-award' },
        { id:'q2', label:'如果遇到挫折，想对孩子说什么', ph:'当孩子面对困难，你最想告诉他/她什么？', icon:'fa-hand-holding-heart' },
        { id:'q3', label:'孩子的梦想，你想让孩子去的学校，为什么', ph:'你了解孩子的梦想吗？你期望的学校和原因？', icon:'fa-star' },
        { id:'q4', label:'给未来的你（家长 / 学生）', ph:'对一年后的自己和孩子，你想说些什么？', icon:'fa-paper-plane' }
    ]
};

/* ========== 页面导航 ========== */
function nav(id) {
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    const el = document.getElementById('pg-' + id);
    if (el) el.classList.add('active');
    window.scrollTo({ top:0, behavior:'smooth' });
}

/* ========== 选择身份 ========== */
function pick(identity) {
    S.identity = identity;
    buildForm();
    nav('form');
}

/* ========== 构建表单 ========== */
function buildForm() {
    const isStu = S.identity === 'student';
    document.getElementById('f-badge').textContent = isStu ? '学生' : '家长';
    document.getElementById('f-title').textContent = isStu ? '写下你的梦想' : '写下你的期许';
    document.getElementById('f-sub').textContent = isStu ? '认真回答每一个问题，一年后再回头看' : '将你对孩子的爱与期待封存';
    document.getElementById('inp-name').value = S.name;
    document.getElementById('inp-email').value = S.email;

    const wrap = document.getElementById('q-wrap');
    const qs = QS[S.identity];
    wrap.innerHTML = qs.map((q,i) => `
        <div class="q-block" style="animation-delay:${i*.08}s">
            <label class="flex items-center gap-3 mb-3">
                <span class="q-num">${i+1}</span>
                <span class="font-semibold" style="color:var(--text);"><i class="fas ${q.icon} mr-1" style="color:var(--accent);font-size:.82rem;"></i>${q.label}</span>
            </label>
            <textarea class="fi" id="inp-${q.id}" placeholder="${q.ph}" rows="3">${S.answers[q.id]||''}</textarea>
        </div>
    `).join('');
}

/* ========== 提交表单（进入预览） ========== */
function submitForm() {
    const name = document.getElementById('inp-name').value.trim();
    const email = document.getElementById('inp-email').value.trim();
    if (!name) { toast('请输入姓名',true); document.getElementById('inp-name').focus(); return; }
    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { toast('请输入有效的邮箱地址',true); document.getElementById('inp-email').focus(); return; }

    const qs = QS[S.identity];
    const ans = {};
    let empty = false;
    qs.forEach(q => {
        const v = document.getElementById('inp-'+q.id).value.trim();
        ans[q.id] = v;
        if (!v) empty = true;
    });
    if (empty) { toast('请回答所有问题后再封存',true); return; }

    S.name = name; S.email = email; S.answers = ans;
    buildPreview();
    nav('preview');
}

/* ========== 构建预览 ========== */
function buildPreview() {
    const isStu = S.identity === 'student';
    document.getElementById('pv-role').textContent = isStu ? '学生' : '家长';
    document.getElementById('pv-name').textContent = S.name + ' 的 Time Capsule';

    const qs = QS[S.identity];
    document.getElementById('pv-qs').innerHTML = qs.map((q,i) => `
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="q-num" style="width:22px;height:22px;font-size:.68rem;">${i+1}</span>
                <span class="text-sm font-semibold" style="color:var(--accent);">${q.label}</span>
            </div>
            <p class="text-sm leading-relaxed" style="color:var(--text-secondary);padding-left:30px;white-space:pre-wrap;">${escHtml(S.answers[q.id])}</p>
        </div>
    `).join('');

    const now = new Date();
    const open = new Date(now); open.setFullYear(open.getFullYear()+1);
    S.openDate = open;
    document.getElementById('pv-seal').textContent = fmtDate(now);
    document.getElementById('pv-open').textContent = fmtDate(open);
}

/* ========== 确认封存（调用后端API） ========== */
async function doSeal() {
    const btn = document.getElementById('btn-seal');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner spin mr-2"></i>封存中...';

    try {
        const resp = await fetch('api/create.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                identity: S.identity,
                name: S.name,
                email: S.email,
                answers: S.answers
            })
        });

        const data = await resp.json();

        if (!resp.ok || data.error) {
            throw new Error(data.error || '服务器错误');
        }

        // 封装成功 — 用服务端返回的日期
        const sealedAt = data.sealed_at || fmtDatetime(new Date());
        const openDateStr = data.open_date;
        const openDate = new Date(openDateStr + 'T00:00:00');
        S.openDate = openDate;

        document.getElementById('s-title').textContent = S.name + ' 的 Time Capsule';
        document.getElementById('s-name').textContent = S.name;
        document.getElementById('s-email').textContent = S.email;
        document.getElementById('s-seal').textContent = sealedAt;
        document.getElementById('s-open').textContent = fmtDate(openDate);

        nav('success');
        startCountdown();

    } catch (err) {
        document.getElementById('err-msg').textContent = err.message || '服务器开小差了，请稍后重试';
        nav('error');
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-lock mr-2"></i>确认封存';
    }
}

/* ========== 倒计时 ========== */
let cdTimer = null;
function startCountdown() {
    if (cdTimer) clearInterval(cdTimer);
    const target = S.openDate.getTime();
    function tick() {
        const diff = Math.max(0, target - Date.now());
        const d = Math.floor(diff / 864e5);
        const h = Math.floor((diff % 864e5) / 36e5);
        const m = Math.floor((diff % 36e5) / 6e4);
        const s = Math.floor((diff % 6e4) / 1e3);
        document.getElementById('cd-d').textContent = String(d).padStart(2,'0');
        document.getElementById('cd-h').textContent = String(h).padStart(2,'0');
        document.getElementById('cd-m').textContent = String(m).padStart(2,'0');
        document.getElementById('cd-s').textContent = String(s).padStart(2,'0');
    }
    tick();
    cdTimer = setInterval(tick, 1000);
}

/* ========== 重置 ========== */
function reset() {
    S.identity=''; S.name=''; S.email=''; S.answers={}; S.openDate=null;
    if (cdTimer) clearInterval(cdTimer);
    nav('landing');
}

/* ========== 工具 ========== */
function fmtDate(d) { return d.getFullYear()+'年'+(d.getMonth()+1)+'月'+d.getDate()+'日'; }
function fmtDatetime(d) { return fmtDate(d)+' '+String(d.getHours()).padStart(2,'0')+':'+String(d.getMinutes()).padStart(2,'0')+':'+String(d.getSeconds()).padStart(2,'0'); }
function escHtml(s) { const d=document.createElement('div'); d.textContent=s; return d.innerHTML; }

let toastTimer = null;
function toast(msg, err) {
    const el = document.getElementById('toast-el');
    el.textContent = msg;
    el.className = 'toast-bar' + (err ? ' err' : '');
    void el.offsetWidth;
    el.classList.add('show');
    if (toastTimer) clearTimeout(toastTimer);
    toastTimer = setTimeout(() => el.classList.remove('show'), 3200);
}

/* ========== 主题 ========== */
function toggleTheme() {
    const h = document.documentElement;
    const next = h.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    h.setAttribute('data-theme', next);
    document.getElementById('theme-ico').className = next === 'dark' ? 'fas fa-moon' : 'fas fa-sun';
    pColor = next === 'dark' ? 'rgba(196,164,66,' : 'rgba(139,105,20,';
}

/* ========== 粒子 ========== */
const cv = document.getElementById('particle-cv');
const cx = cv.getContext('2d');
let pts = [], pColor = 'rgba(196,164,66,';

function rsCv() { cv.width = innerWidth; cv.height = innerHeight; }

function initPts() {
    rsCv(); pts = [];
    const n = Math.min(70, Math.floor(innerWidth * innerHeight / 18000));
    for (let i = 0; i < n; i++) {
        pts.push({ x:Math.random()*cv.width, y:Math.random()*cv.height, r:Math.random()*1.4+.4, vx:(Math.random()-.5)*.25, vy:(Math.random()-.5)*.25, a:Math.random()*.45+.08, p:Math.random()*Math.PI*2 });
    }
}

function drawPts() {
    cx.clearRect(0,0,cv.width,cv.height);
    for (const p of pts) {
        p.x+=p.vx; p.y+=p.vy; p.p+=.015;
        if(p.x<-10)p.x=cv.width+10; if(p.x>cv.width+10)p.x=-10;
        if(p.y<-10)p.y=cv.height+10; if(p.y>cv.height+10)p.y=-10;
        const alpha=p.a*(.7+.3*Math.sin(p.p));
        cx.beginPath(); cx.arc(p.x,p.y,Math.max(.1,p.r),0,Math.PI*2);
        cx.fillStyle=pColor+alpha.toFixed(3)+')'; cx.fill();
    }
    requestAnimationFrame(drawPts);
}

window.addEventListener('resize', rsCv);
initPts(); drawPts();

document.querySelectorAll('.id-card').forEach(c => {
    c.addEventListener('keydown', e => { if(e.key==='Enter'||e.key===' '){e.preventDefault();c.click();} });
});
</script>
</body>
</html>
