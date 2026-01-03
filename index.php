<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>AI Compare</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<!-- ===== SIDEBAR ===== -->
<nav class="sidebar close">
    <header>
        <div class="image-text">
            <img src="logo.png" class="logo-img">
        
            </div>
        </div>
        <i class='bx bx-chevron-right toggle'></i>
    </header>

     <ul>
        <li><a href="about.html"><i class='bx bx-home'></i><span class="text">Tentang Saya</span></a></li>
        <li><a href="index.php" class="active"><i class='bx bx-bot'></i><span class="text">AI Compare</span></a></li>
        <li><a href="benchmark.html"><i class='bx bx-bar-chart'></i><span class="text">Benchmark</span></a></li>
    </ul>
</nav>

<!-- ===== MAIN CONTENT ===== -->
<div class="container py-5 main-content">

    <div class="mb-4 text-center">
        <div class="title">⚡ AI Compare</div>
        <small class="text-info">Gemma vs Nemotron</small>
    </div>

    <!-- INPUT -->
    <div class="glass mb-4">
        <textarea id="promptBox" class="form-control mb-3" rows="3"
            placeholder="Tulis prompt Anda di sini..."></textarea>

        <div class="row g-3">
            <div class="col-md-6">
                <select id="modelA" class="form-select">
                    <option value="google/gemma-3-27b-it:free">Gemma 3</option>
                </select>
            </div>
            <div class="col-md-6">
                <select id="modelB" class="form-select">
                    <option value="nvidia/nemotron-nano-12b-v2-vl:free">Nemotron Nano</option>
                </select>
            </div>
        </div>

        <button class="btn-ai w-100 mt-4" onclick="start()">🚀 COMPARE AI</button>
    </div>

    <!-- OUTPUT VERTICAL -->
    <div class="glass mb-4">
        <h6 class="text-info">🤖 Gemma</h6>
        <div id="loaderA" class="loader d-none"></div>
        <div id="a" class="markdown-output"></div>
    </div>

    <div class="glass">
        <h6 class="text-info">🧠 Nemotron</h6>
        <div id="loaderB" class="loader d-none"></div>
        <div id="b" class="markdown-output"></div>
    </div>

</div>

<script>
marked.setOptions({
    breaks: true,
    gfm: true,
    headerIds: false,
    mangle: false
});

async function run(target, loader, model) {
    const prompt = promptBox.value.trim();
    if (!prompt) return;

    const box = document.getElementById(target);
    const load = document.getElementById(loader);

    box.innerHTML = "";
    load.classList.remove("d-none");

    try {
        const res = await fetch(
            `stream.php?model=${encodeURIComponent(model)}&prompt=${encodeURIComponent(prompt)}`
        );
        const data = await res.json();
        load.classList.add("d-none");

        if (data.error) {
            box.innerHTML = "⚠️ " + data.error;
            return;
        }

        fakeStream(box, data.text);

    } catch {
        load.classList.add("d-none");
        box.innerHTML = "⚠️ Koneksi AI terputus.";
    }
}

function fakeStream(box, text) {
    let i = 0;
    let buffer = "";

    function type() {
        if (i >= text.length) return;
        buffer += text[i++];
        box.innerHTML = marked.parse(buffer);
        box.scrollTop = box.scrollHeight;
        setTimeout(type, 12); // speed typing
    }

    type();
}

function start() {
    run("a", "loaderA", modelA.value);
    run("b", "loaderB", modelB.value);
}

/* sidebar toggle */
const sidebar = document.querySelector(".sidebar");
document.querySelector(".toggle").onclick = () => {
    sidebar.classList.toggle("close");
};
</script>

</body>
</html>
