<?php
/**
 * Snippet: Jari Nada App
 *
 * Serves the Jari Nada app at mustimusik.id/jarinada, completely
 * bypassing the theme/Elementor so styling and <script> tags survive
 * untouched by WordPress content filtering.
 *
 * Setup:
 * 1. Pages -> Add Page. Title: "Jari Nada". Leave content empty.
 *    Click "Edit" next to the permalink under the title and set the
 *    slug to exactly: jarinada
 *    Click Publish.
 * 2. Code Snippets -> Add New. Paste this entire file's contents.
 *    Save Changes, then Activate.
 * 3. Visit mustimusik.id/jarinada to confirm it loads.
 *
 * IMPORTANT: this snippet must run "Everywhere" / "Run Everywhere",
 * NOT "Only on site front-end" — the view/click counters below need
 * the wp_ajax_* hooks (fired via admin-ajax.php) and the dashboard
 * widget needs the wp-admin context, both of which a front-end-only
 * setting would block.
 */

// ---------- Page view counter ----------
// Fires once per page load (see fetch() near the top of the app's script).
add_action('wp_ajax_jarinada_view', 'jarinada_increment_view');
add_action('wp_ajax_nopriv_jarinada_view', 'jarinada_increment_view');
function jarinada_increment_view(){
    $count = (int) get_option('jarinada_view_count', 0);
    $count++;
    update_option('jarinada_view_count', $count);
    wp_send_json_success(['count' => $count]);
}

// ---------- Masterclass CTA click counter ----------
// Fires whenever the top masterclass badge is clicked.
add_action('wp_ajax_jarinada_masterclass_click', 'jarinada_increment_masterclass_click');
add_action('wp_ajax_nopriv_jarinada_masterclass_click', 'jarinada_increment_masterclass_click');
function jarinada_increment_masterclass_click(){
    $count = (int) get_option('jarinada_masterclass_click_count', 0);
    $count++;
    update_option('jarinada_masterclass_click_count', $count);
    wp_send_json_success(['count' => $count]);
}

add_action('wp_dashboard_setup', function(){
    wp_add_dashboard_widget('jarinada_stats', 'Jari Nada — Statistik', function(){
        $views = (int) get_option('jarinada_view_count', 0);
        $clicks = (int) get_option('jarinada_masterclass_click_count', 0);
        $rate = $views > 0 ? round(($clicks / $views) * 100, 1) : 0;
        echo '<p style="font-size:32px;font-weight:700;margin:0;">' . esc_html($views) . '</p><p style="margin:4px 0 14px;color:#666;">Total kunjungan halaman</p>';
        echo '<p style="font-size:32px;font-weight:700;margin:0;">' . esc_html($clicks) . '</p><p style="margin:4px 0 4px;color:#666;">Klik ke Masterclass</p>';
        echo '<p style="margin:0;color:#999;font-size:12px;">Conversion rate: ' . esc_html($rate) . '%</p>';
    });
});

add_action('template_redirect', function () {
    if (is_page('jarinada')) {
        // WP Rocket (and similar optimizers) rewrite <script> tags —
        // including our own inline app script — to defer/delay execution
        // until after the first user interaction, and replay that first
        // click synthetically. That breaks getUserMedia()/AudioContext,
        // which require a genuine trusted user gesture. This constant is
        // WP Rocket's documented escape hatch to skip ALL HTML/JS/CSS
        // optimization (minify, defer, delay-JS, etc.) for this response.
        if (!defined('DONOTROCKETOPTIMIZE')) {
            define('DONOTROCKETOPTIMIZE', true);
        }
        header('Content-Type: text/html; charset=utf-8');
        // Bounded caching, not zero caching: a "no-store" here previously
        // made WP Rocket/Cloudflare skip caching this page entirely, so
        // every visit paid for a full WordPress boot + 20-plugin load with
        // no static cache to short-circuit it — very slow. This page's
        // content is static (per-visitor state like UTM/counters is all
        // resolved client-side in JS), so it's safe to cache; max-age just
        // caps how long an update can stay stale to 5 minutes instead of
        // forever. After editing this snippet, purge the WP Rocket cache
        // once if you want the change live immediately.
        header('Cache-Control: public, max-age=300');
        echo <<<'JARINADA_HTML'
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover" />
<meta name="theme-color" content="#000000" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>%F0%9F%8E%B5</text></svg>">
<title>Jari Nada — Mainkan Kord dengan Gerakan Tangan</title>
<meta name="description" content="Mainkan kord musik langsung pakai gerakan tangan lewat kamera. Tangan kiri pilih not, tangan kanan pilih jenis kord.">
<meta property="og:title" content="Jari Nada — Mainkan Kord dengan Gerakan Tangan">
<meta property="og:description" content="Mainkan kord musik langsung pakai gerakan tangan lewat kamera. Tangan kiri pilih not, tangan kanan pilih jenis kord.">
<meta property="og:type" content="website">
<meta property="og:url" content="https://mustimusik.id/jarinada">
<meta name="twitter:card" content="summary">
<style>
  * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
  html, body { margin: 0; padding: 0; background: #000; color: #fff; height: 100%;
    font-family: -apple-system, BlinkMacSystemFont, "Helvetica Neue", Arial, sans-serif; overflow: hidden; }

  #app { position: relative; width: 100vw; height: 100vh; height: 100dvh; }

  video, canvas#overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%;
    object-fit: cover; transform: scaleX(-1); }
  canvas#overlay { pointer-events: none; }

  #controls { position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%); z-index: 10;
    display: flex; align-items: center; gap: 16px; background: rgba(0,0,0,0.5); padding: 8px 16px;
    border-radius: 12px; backdrop-filter: blur(4px); font-size: 13px; white-space: nowrap; }
  #controls label { display: flex; align-items: center; gap: 6px; color: #ddd; cursor: pointer; }
  #controls select { background: #1a1a1a; color: #fff; border: 1px solid #444; border-radius: 6px;
    padding: 4px 6px; font-size: 13px; }
  #resetBtn { background: transparent; border: 1px solid #444; color: #ccc; border-radius: 8px;
    width: 30px; height: 30px; font-size: 15px; cursor: pointer; }
  #resetBtn:hover { background: #222; }

  #hint { position: absolute; bottom: 56px; left: 10px; right: 10px; text-align: center;
    font-size: 11px; color: #999; z-index: 10; }

  #start { position: absolute; inset: 0; z-index: 30; display: flex; flex-direction: column;
    align-items: center; justify-content: center; gap: 10px; background: #000; text-align: center; padding: 20px; }
  #start h1 { font-size: 32px; margin: 0; letter-spacing: -0.02em; }
  #start p { color: #bbb; max-width: 360px; margin: 0; line-height: 1.6; font-size: 14px; text-wrap: balance; }
  #start .note { color: #666; font-size: 12px; max-width: 320px; }
  #start button { font-size: 15px; padding: 12px 30px; border-radius: 999px; border: none;
    background: #7CFFB2; color: #000; font-weight: 700; cursor: pointer; margin-top: 12px; }
  #start .brand { font-size: 11px; color: #666; letter-spacing: 0.04em; }

  #promoBadge { position: absolute; top: 10px; left: 50%; transform: translateX(-50%); z-index: 10;
    background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); border: 1px solid rgba(124,255,178,0.4);
    border-radius: 999px; padding: 5px 14px; font-size: 11px; color: #ddd; text-decoration: none; }
  #promoBadge strong { color: #7CFFB2; }

  #rotate { position: absolute; inset: 0; z-index: 40; display: none; flex-direction: column;
    align-items: center; justify-content: center; gap: 10px; background: #000; text-align: center; padding: 20px; }
  #rotate .icon { font-size: 40px; }
  #rotate h2 { margin: 0; font-size: 18px; }
  #rotate p { color: #999; font-size: 13px; margin: 0; max-width: 260px; }

  @media (orientation: portrait) {
    #rotate { display: flex; }
    #app > *:not(#rotate) { visibility: hidden; }
  }
</style>
</head>
<body>
<div id="app">
  <video id="video" autoplay playsinline muted></video>
  <canvas id="overlay"></canvas>

  <a id="promoBadge" class="masterclassCta" href="#" target="_blank" rel="noopener">Mau belajar <strong>HEARING</strong> chord dalam 1 hari? Yuk bareng Musti Musik →</a>

  <div id="hint">Tangan kiri: arahkan & tahan telunjuk untuk memainkan not &nbsp;·&nbsp; Tangan kanan: arahkan & tahan telunjuk untuk memainkan jenis kord</div>

  <div id="controls">
    <label title="Mati: roda not hanya 7 huruf (C D E F G A B). Nyala: roda not jadi 12 nada kromatik termasuk nada kres (#).">
      <input type="checkbox" id="sharpsCheck" /> 12 Nada
    </label>
    <label title="Ganti karakter suara">
      Suara
      <select id="soundSelect">
        <option value="sine">Sine Murni</option>
        <option value="warmTriangle">Warm Triangle</option>
        <option value="richSaw">Rich Saw</option>
        <option value="fmBell" selected>FM Bell</option>
        <option value="unisonPad">Unison Pad</option>
      </select>
    </label>
    <button id="resetBtn" title="Atur ulang">↻</button>
  </div>

  <div id="rotate">
    <div class="icon">↻</div>
    <h2>PUTAR HP-NYA YA</h2>
    <p>Jari Nada cuma bekerja di layar mendatar!<br/>by Musti Musik!</p>
  </div>

  <div id="start">
    <h1>Jari Nada</h1>
    <p>Pakai kedua tangan untuk main chord di kunci apapun!</p>
    <p class="note">Izinkan akses kamera untuk mulai main yaa! (Tidak ada data terekam, tenang aja)</p>
    <button id="startBtn">Mulai</button>
    <span class="brand">by Musti Musik!</span>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
<script>
(function () {
  "use strict";

  // ---------------- Page view tracking ----------------
  // Fires once per load. Counts everyone who actually lands on the page,
  // regardless of whether they grant camera access or press Mulai.
  fetch('/wp-admin/admin-ajax.php?action=jarinada_view', { method: 'POST' }).catch(() => {});

  // ---------------- Masterclass CTA (top badge): UTM by incoming ?utm_source ----------------
  // The outgoing masterclass link's utm_source is taken from the ?utm_source
  // on THIS page's URL (set by whatever bio link/QR/group message brought
  // the visitor here), not from the referrer.
  (function setupMasterclassLinks() {
    const MASTERCLASS_LINKS = {
      instagram: "https://akademimustimusik.form.id/masterclass-jul?utm_source=instagram&utm_medium=short&utm_content=jarinada",
      tiktok: "https://akademimustimusik.form.id/masterclass-jul?utm_source=tiktok&utm_medium=short&utm_content=jarinada",
      youtube: "https://akademimustimusik.form.id/masterclass-jul?utm_source=youtube&utm_medium=short&utm_content=jarinada",
      whatsapp: "https://akademimustimusik.form.id/masterclass-jul?utm_source=whatsapp&utm_medium=group&utm_content=jarinada"
    };
    const FALLBACK_MASTERCLASS_LINK = "https://akademimustimusik.form.id/masterclass-jul?utm_source=google&utm_content=jarinada";
    function getMasterclassLink() {
      const source = new URLSearchParams(location.search).get('utm_source');
      return MASTERCLASS_LINKS[source] || FALLBACK_MASTERCLASS_LINK;
    }
    const url = getMasterclassLink();
    document.querySelectorAll('.masterclassCta').forEach((a) => {
      a.href = url;
      a.addEventListener('click', () => {
        fetch('/wp-admin/admin-ajax.php?action=jarinada_masterclass_click', { method: 'POST' }).catch(() => {});
      });
    });
  })();

  // ============================================================
  // NOTE: soundgo's exact internal algorithm isn't public, so the
  // wheel layout/labels are matched to what's visible on screen,
  // but the underlying music logic (angle->note mapping, chord
  // voicing, which hand drives what) is my own reconstruction.
  // ============================================================

  const state = { timbre: 'fmBell', simple: true };

  // Simple mode: 7 natural letters. Chromatic mode (Simple unchecked): 12 notes with sharps.
  const NOTE_SEGMENTS_SIMPLE = ['C', 'D', 'E', 'F', 'G', 'A', 'B'];
  const NOTE_PC_SIMPLE = [0, 2, 4, 5, 7, 9, 11];
  const NOTE_SEGMENTS_CHROMATIC = ['C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B'];
  const NOTE_PC_CHROMATIC = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];

  function currentNoteSegments() { return state.simple ? NOTE_SEGMENTS_SIMPLE : NOTE_SEGMENTS_CHROMATIC; }
  function currentNotePcs() { return state.simple ? NOTE_PC_SIMPLE : NOTE_PC_CHROMATIC; }

  const CHORD_SEGMENTS = ['maj', 'm', '7', 'maj7', 'm7', 'm7b5', 'sus4', 'aug', 'dim'];
  const CHORD_INTERVALS = {
    maj:   [0, 4, 7],
    m:     [0, 3, 7],
    '7':   [0, 4, 7, 10],
    maj7:  [0, 4, 7, 11],
    m7:    [0, 3, 7, 10],
    m7b5:  [0, 3, 6, 10],
    sus4:  [0, 5, 7],
    aug:   [0, 4, 8],
    dim:   [0, 3, 6]
  };

  function midiToFreq(m) { return 440 * Math.pow(2, (m - 69) / 12); }

  // ---------------- Color system ----------------
  // Each of the 12 pitch classes gets a fixed, distinct color spread evenly
  // around the color wheel (hue = pc * 30deg), so "C" is always the same
  // color everywhere in the app. A chord's color is the average of the
  // colors of the notes it's built from, computed live from root+quality.
  function hslToRgb(h, s, l) {
    s /= 100; l /= 100;
    const k = n => (n + h / 30) % 12;
    const a = s * Math.min(l, 1 - l);
    const f = n => l - a * Math.max(-1, Math.min(k(n) - 3, Math.min(9 - k(n), 1)));
    return { r: Math.round(255 * f(0)), g: Math.round(255 * f(8)), b: Math.round(255 * f(4)) };
  }
  function pcColor(pc) { return hslToRgb((pc * 30) % 360, 72, 58); }
  function blendColors(pcs) {
    let r = 0, g = 0, b = 0;
    pcs.forEach(pc => { const c = pcColor(pc); r += c.r; g += c.g; b += c.b; });
    const n = pcs.length || 1;
    return { r: Math.round(r / n), g: Math.round(g / n), b: Math.round(b / n) };
  }
  function rgbStr(c, alpha) {
    return alpha === undefined ? `rgb(${c.r},${c.g},${c.b})` : `rgba(${c.r},${c.g},${c.b},${alpha})`;
  }

  // Notes are always quantized to the wheel segment you're pointing at
  // (no in-between/microtonal pitch) — tilting slightly within segment C
  // keeps playing C; only crossing into D's slice jumps straight to D.
  function nearestSegment(theta, n) {
    const seg = (2 * Math.PI) / n;
    let i = Math.round((-Math.PI / 2 - theta) / seg) % n;
    if (i < 0) i += n;
    return i;
  }
  function segmentAngle(i, n) { return -Math.PI / 2 - i * (2 * Math.PI / n); }

  // ---------------- Audio engine ----------------
  // Each "voice" is a small self-contained synth graph (oscillator(s) +
  // optional filter + gain) exposing just setFreq/setGain — swapping the
  // whole timbre (TIMBRE_PRESETS below) just means building a different
  // graph per voice; the melody/chord logic never touches oscillators
  // directly. gainTrim per preset keeps perceived loudness roughly even
  // across presets that use different numbers of oscillators.
  let audioCtx;
  let melodyVoice = null;
  let chordVoices = [];

  const TIMBRE_PRESETS = {
    sine: {
      label: 'Sine Murni',
      build(ctx) {
        const osc = ctx.createOscillator();
        const gain = ctx.createGain();
        osc.type = 'sine';
        gain.gain.value = 0;
        osc.frequency.value = 440;
        osc.connect(gain).connect(ctx.destination);
        osc.start();
        return {
          setFreq: (f, t, g) => osc.frequency.setTargetAtTime(f, t, g),
          setGain: (v, t, r) => gain.gain.setTargetAtTime(v, t, r),
          stopAll: () => { try { osc.stop(); } catch (e) {} }
        };
      }
    },
    warmTriangle: {
      label: 'Warm Triangle',
      build(ctx) {
        const osc = ctx.createOscillator();
        const filter = ctx.createBiquadFilter();
        const gain = ctx.createGain();
        osc.type = 'triangle';
        filter.type = 'lowpass';
        filter.frequency.value = 2600;
        filter.Q.value = 0.6;
        gain.gain.value = 0;
        osc.frequency.value = 440;
        osc.connect(filter).connect(gain).connect(ctx.destination);
        osc.start();
        return {
          setFreq: (f, t, g) => osc.frequency.setTargetAtTime(f, t, g),
          setGain: (v, t, r) => gain.gain.setTargetAtTime(v, t, r),
          stopAll: () => { try { osc.stop(); } catch (e) {} }
        };
      }
    },
    richSaw: {
      label: 'Rich Saw',
      build(ctx) {
        const osc = ctx.createOscillator();
        const filter = ctx.createBiquadFilter();
        const gain = ctx.createGain();
        const TRIM = 0.85;
        osc.type = 'sawtooth';
        filter.type = 'lowpass';
        filter.frequency.value = 1700;
        filter.Q.value = 1.1;
        gain.gain.value = 0;
        osc.frequency.value = 440;
        osc.connect(filter).connect(gain).connect(ctx.destination);
        osc.start();
        return {
          // filter brightness tracks pitch a bit, so low notes stay warm and
          // high notes don't get muddy under the lowpass
          setFreq: (f, t, g) => { osc.frequency.setTargetAtTime(f, t, g); filter.frequency.setTargetAtTime(Math.min(4200, f * 4), t, g); },
          setGain: (v, t, r) => gain.gain.setTargetAtTime(v * TRIM, t, r),
          stopAll: () => { try { osc.stop(); } catch (e) {} }
        };
      }
    },
    fmBell: {
      label: 'FM Bell',
      build(ctx) {
        const carrier = ctx.createOscillator();
        const modulator = ctx.createOscillator();
        const modGain = ctx.createGain();
        const gain = ctx.createGain();
        const TRIM = 0.9;
        carrier.type = 'sine';
        modulator.type = 'sine';
        carrier.frequency.value = 440;
        modulator.frequency.value = 880; // 2:1 ratio -> bell/electric-piano character
        modGain.gain.value = 260;
        modulator.connect(modGain).connect(carrier.frequency);
        gain.gain.value = 0;
        carrier.connect(gain).connect(ctx.destination);
        carrier.start();
        modulator.start();
        return {
          setFreq: (f, t, g) => {
            carrier.frequency.setTargetAtTime(f, t, g);
            modulator.frequency.setTargetAtTime(f * 2, t, g);
            modGain.gain.setTargetAtTime(f * 0.6, t, g); // scale mod depth with pitch for a consistent timbre
          },
          setGain: (v, t, r) => gain.gain.setTargetAtTime(v * TRIM, t, r),
          stopAll: () => { try { carrier.stop(); modulator.stop(); } catch (e) {} }
        };
      }
    },
    unisonPad: {
      label: 'Unison Pad',
      build(ctx) {
        const oscA = ctx.createOscillator();
        const oscB = ctx.createOscillator();
        const filter = ctx.createBiquadFilter();
        const gain = ctx.createGain();
        const TRIM = 0.7;
        oscA.type = 'sawtooth';
        oscB.type = 'sawtooth';
        oscA.detune.value = -9;
        oscB.detune.value = 9; // slight detune between the pair = classic analog "fatness"
        filter.type = 'lowpass';
        filter.frequency.value = 2200;
        gain.gain.value = 0;
        oscA.frequency.value = 440;
        oscB.frequency.value = 440;
        oscA.connect(filter);
        oscB.connect(filter);
        filter.connect(gain).connect(ctx.destination);
        oscA.start();
        oscB.start();
        return {
          setFreq: (f, t, g) => { oscA.frequency.setTargetAtTime(f, t, g); oscB.frequency.setTargetAtTime(f, t, g); },
          setGain: (v, t, r) => gain.gain.setTargetAtTime(v * TRIM, t, r),
          stopAll: () => { try { oscA.stop(); oscB.stop(); } catch (e) {} }
        };
      }
    }
  };

  function buildVoices() {
    const preset = TIMBRE_PRESETS[state.timbre] || TIMBRE_PRESETS.sine;
    melodyVoice = preset.build(audioCtx);
    chordVoices = [0, 1, 2, 3].map(() => preset.build(audioCtx));
  }

  function initAudio() {
    audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    buildVoices();
  }

  // Swaps the whole voice graph live. Old voices are faded out and stopped
  // shortly after so the switch doesn't click, even mid-note.
  function setTimbre(key) {
    if (!TIMBRE_PRESETS[key] || key === state.timbre) return;
    state.timbre = key;
    if (!audioCtx) return; // not started yet — buildVoices() at initAudio() will pick it up
    const old = [melodyVoice, ...chordVoices];
    const now = audioCtx.currentTime;
    old.forEach(v => v.setGain(0, now, 0.03));
    setTimeout(() => old.forEach(v => v.stopAll()), 120);
    buildVoices();
  }

  // Portamento: how long a slide between two notes/chords takes, in seconds.
  // This is what makes moving from one note to another sound like a smooth
  // slide instead of an abrupt jump, while the note SELECTION itself still
  // stays quantized (segment-locked, no microtones).
  const GLIDE_TIME = 0.12;

  function setMelody(freq, vol) {
    if (!melodyVoice) return;
    const now = audioCtx.currentTime;
    melodyVoice.setFreq(freq, now, GLIDE_TIME);
    melodyVoice.setGain(vol * 0.3, now, 0.06);
  }

  function setChord(rootMidi, quality, vol) {
    if (!chordVoices.length) return;
    const now = audioCtx.currentTime;
    const intervals = CHORD_INTERVALS[quality] || CHORD_INTERVALS.maj;
    chordVoices.forEach((v, i) => {
      if (intervals[i] !== undefined && vol > 0) {
        v.setFreq(midiToFreq(rootMidi + intervals[i]), now, GLIDE_TIME);
        v.setGain(vol * 0.14, now, 0.08);
      } else {
        v.setGain(0, now, 0.08);
      }
    });
  }

  // ---------------- UI wiring ----------------
  document.getElementById('sharpsCheck').addEventListener('change', (e) => { state.simple = !e.target.checked; });
  document.getElementById('soundSelect').addEventListener('change', (e) => { setTimbre(e.target.value); });
  document.getElementById('resetBtn').addEventListener('click', () => {
    state.simple = true;
    document.getElementById('sharpsCheck').checked = false;
    setMelody(440, 0);
    setChord(60, 'maj', 0);
  });

  // ---------------- Hand tracking ----------------
  const video = document.getElementById('video');
  const canvas = document.getElementById('overlay');
  const ctx2d = canvas.getContext('2d');

  let lockedRootPc = 0; // last note (pitch class 0-11) selected, used as chord root even if that hand leaves frame
  let lockedRootLabel = 'C';
  let lockedQuality = 'maj'; // last committed chord quality, sustained while the chord hand is in the center dead zone

  // Dwell tracking: which segment each hand is currently sitting on, and
  // when it arrived there. Reset to null whenever the hand disappears so
  // a fresh dwell is required next time it reappears anywhere.
  let noteHoverIdx = null, noteHoverSince = 0;
  let chordHoverIdx = null, chordHoverSince = 0;

  const MELODY_VOLUME = 0.9;
  const CHORD_VOLUME = 0.75;

  // Gesture: dwell-to-commit. Just having the hand tracked and pointing at
  // a segment previews it (dimmed, silent); staying on that SAME segment
  // for DWELL_MS actually commits/plays it. Sweeping across segments to
  // reach a distant one resets the timer every time you cross into a new
  // segment, so a fast sweep never lingers long enough to trigger the ones
  // you pass through — only the one you settle on. This also drops the
  // earlier "finger must be perfectly straight" check, which was
  // unreliable for hands that point with a natural, slightly curled shape.
  const DWELL_MS = 120;
  // The black center disc (same radius the wheel is drawn with, see
  // drawWheel below) is a genuine dead zone: angle-based segment picking
  // still applies arbitrarily close to the center, so without this, tiny
  // hand tremor while resting there flickers between random segments.
  // Treating it as neutral lets you stage your hand in the middle and
  // dart out to a distant note without it "catching" on the way in.
  const CENTER_DEAD_ZONE_RATIO = 0.36;
  function drawFingerIndicator(lm, active, holdRatio) {
    if (!lm) return;
    const w = canvas.width, h = canvas.height;
    const tip = { x: lm[8].x * w, y: lm[8].y * h };
    const r = active ? 9 : 6;
    ctx2d.beginPath();
    ctx2d.arc(tip.x, tip.y, r, 0, Math.PI * 2);
    ctx2d.fillStyle = active ? 'rgba(124,255,178,0.9)' : 'rgba(255,255,255,0.4)';
    ctx2d.fill();
    if (!active && holdRatio > 0) {
      // Fill-up ring showing progress toward commit, so it's clear
      // something IS happening during the dwell window, not a dead spot.
      ctx2d.beginPath();
      ctx2d.arc(tip.x, tip.y, r + 5, -Math.PI / 2, -Math.PI / 2 + holdRatio * Math.PI * 2);
      ctx2d.strokeStyle = 'rgba(124,255,178,0.85)';
      ctx2d.lineWidth = 3;
      ctx2d.stroke();
    }
  }

  function drawWheel(cx, cy, radius, segments, centerLabel, pointerPt, color, segmentColors) {
    const n = segments.length;
    const seg = (2 * Math.PI) / n;

    // background: colored wedges per note if segmentColors given (note
    // wheel), otherwise one flat gray disc (chord-quality wheel, which
    // gets its color dynamically only when a chord is actually playing).
    if (segmentColors) {
      for (let i = 0; i < n; i++) {
        const a0 = segmentAngle(i, n) - seg / 2;
        const a1 = a0 + seg;
        ctx2d.beginPath();
        ctx2d.moveTo(cx, cy);
        ctx2d.arc(cx, cy, radius, a0, a1);
        ctx2d.closePath();
        ctx2d.fillStyle = rgbStr(segmentColors[i], 0.4);
        ctx2d.fill();
      }
    } else {
      ctx2d.beginPath();
      ctx2d.arc(cx, cy, radius, 0, Math.PI * 2);
      ctx2d.fillStyle = 'rgba(120,120,120,0.28)';
      ctx2d.fill();
    }
    ctx2d.beginPath();
    ctx2d.arc(cx, cy, radius, 0, Math.PI * 2);
    ctx2d.strokeStyle = 'rgba(255,255,255,0.5)';
    ctx2d.lineWidth = 1.5;
    ctx2d.stroke();

    // divider lines
    ctx2d.strokeStyle = 'rgba(255,255,255,0.35)';
    for (let i = 0; i < n; i++) {
      const a = segmentAngle(i, n) - seg / 2;
      ctx2d.beginPath();
      ctx2d.moveTo(cx + Math.cos(a) * radius * 0.38, cy + Math.sin(a) * radius * 0.38);
      ctx2d.lineTo(cx + Math.cos(a) * radius, cy + Math.sin(a) * radius);
      ctx2d.stroke();
    }

    // labels
    const labelSize = Math.max(10, Math.round(radius * 0.16));
    ctx2d.fillStyle = 'rgba(255,255,255,0.9)';
    ctx2d.font = `600 ${labelSize}px -apple-system, sans-serif`;
    ctx2d.textAlign = 'center';
    ctx2d.textBaseline = 'middle';
    for (let i = 0; i < n; i++) {
      const a = segmentAngle(i, n);
      const lx = cx + Math.cos(a) * radius * 0.7;
      const ly = cy + Math.sin(a) * radius * 0.7;
      ctx2d.save();
      ctx2d.scale(-1, 1); // un-mirror text so it reads correctly after CSS scaleX(-1)
      ctx2d.fillText(segments[i], -lx, ly);
      ctx2d.restore();
    }

    // pointer line to hand position
    if (pointerPt) {
      ctx2d.strokeStyle = '#fff';
      ctx2d.lineWidth = 3;
      ctx2d.beginPath();
      ctx2d.moveTo(cx, cy);
      ctx2d.lineTo(pointerPt.x, pointerPt.y);
      ctx2d.stroke();
    }

    // center disc
    ctx2d.beginPath();
    ctx2d.arc(cx, cy, radius * CENTER_DEAD_ZONE_RATIO, 0, Math.PI * 2);
    ctx2d.fillStyle = 'rgba(0,0,0,0.75)';
    ctx2d.fill();
    ctx2d.fillStyle = color;
    ctx2d.font = `600 ${Math.max(11, Math.round(radius * 0.18))}px -apple-system, sans-serif`;
    ctx2d.save();
    ctx2d.scale(-1, 1);
    ctx2d.fillText(centerLabel, -cx, cy);
    ctx2d.restore();
  }

  // Some page-speed optimizers (e.g. WP Rocket's "Delay JavaScript
  // Execution") can defer loading these third-party <script> tags until
  // after the first user interaction, so window.Hands/window.Camera may
  // not exist yet even though their <script> tags appear earlier in the
  // document. Poll for them instead of assuming they're ready.
  function waitForGlobal(name, timeoutMs) {
    return new Promise((resolve, reject) => {
      const start = Date.now();
      (function poll() {
        if (window[name]) return resolve(window[name]);
        if (Date.now() - start > timeoutMs) return reject(new Error(`${name} gagal dimuat (timeout)`));
        setTimeout(poll, 50);
      })();
    });
  }

  let hands = null; // built lazily once the Hands library is confirmed loaded

  function handleHandResults(results) {
    // A momentary camera hiccup can report a 0x0 frame — skip it instead
    // of zeroing the canvas out (which would silently blank both wheels
    // until another valid frame happens to arrive).
    if (!video.videoWidth || !video.videoHeight) return;

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    ctx2d.clearRect(0, 0, canvas.width, canvas.height);

    const W = canvas.width, H = canvas.height;
    // Keep wheels small enough that they never overlap: distance between
    // centers is 0.5*W, so radius is capped well under half of that, and
    // also capped by height so it fits comfortably in landscape frames.
    const radius = Math.min(W * 0.12, H * 0.24);
    // Raw-space centers chosen so that after CSS mirroring the NOTE wheel
    // appears on screen-left and the CHORD wheel appears on screen-right.
    const noteCenter = { x: W * 0.75, y: H * 0.5 };
    const chordCenter = { x: W * 0.25, y: H * 0.5 };

    const landmarksList = results.multiHandLandmarks || [];

    // Assign hands to wheels by raw x position of the index fingertip
    // (larger raw x -> mirrors to screen-left -> controls the note wheel;
    // the other hand controls the chord wheel).
    let noteHand = null, chordHand = null;
    if (landmarksList.length === 1) {
      const lm = landmarksList[0];
      const dNote = Math.abs(lm[8].x * W - noteCenter.x);
      const dChord = Math.abs(lm[8].x * W - chordCenter.x);
      if (dNote <= dChord) noteHand = lm; else chordHand = lm;
    } else if (landmarksList.length >= 2) {
      const sorted = landmarksList.slice().sort((a, b) => (b[8].x - a[8].x));
      noteHand = sorted[0];
      chordHand = sorted[1];
    }

    // ---- Selection pass (no drawing yet) ----
    // A visible index fingertip only PREVIEWS which segment you're
    // hovering over (wheel highlight dims, no sound). Staying on that same
    // segment for DWELL_MS COMMITS it and actually plays it — this is what
    // stops incidental hand movement (and fast sweeps to a distant segment)
    // from misfiring notes/chords along the way.
    const now = performance.now();
    const noteSegments = currentNoteSegments();
    const notePcs = currentNotePcs();
    const noteSegmentColors = notePcs.map(pcColor);

    let notePt = null, noteIdx = null, noteLetter = null, noteActive = false, noteHoldRatio = 0, noteInDeadZone = false;
    if (noteHand) {
      notePt = { x: noteHand[8].x * W, y: noteHand[8].y * H };
      const dx = notePt.x - noteCenter.x, dy = notePt.y - noteCenter.y;
      noteInDeadZone = Math.hypot(dx, dy) < radius * CENTER_DEAD_ZONE_RATIO;
      if (noteInDeadZone) {
        // Neutral: don't count this toward any segment's dwell, but keep
        // sustaining whatever note was already locked in — it's a staging
        // point for transit, not a mute button.
        noteHoverIdx = null;
        noteActive = true;
        setMelody(midiToFreq(60 + lockedRootPc), MELODY_VOLUME);
      } else {
        const theta = Math.atan2(dy, dx);
        noteIdx = nearestSegment(theta, noteSegments.length);
        noteLetter = noteSegments[noteIdx];
        if (noteIdx !== noteHoverIdx) { noteHoverIdx = noteIdx; noteHoverSince = now; }
        noteHoldRatio = Math.min(1, (now - noteHoverSince) / DWELL_MS);
        noteActive = noteHoldRatio >= 1;
        if (noteActive) {
          lockedRootPc = notePcs[noteIdx];
          lockedRootLabel = noteLetter;
          const freq = midiToFreq(60 + notePcs[noteIdx]); // C4-based melody
          setMelody(freq, MELODY_VOLUME);
        } else {
          setMelody(440, 0);
        }
      }
    } else {
      noteHoverIdx = null;
      setMelody(440, 0);
    }

    let chordPt = null, qualityLabel = 'maj', chordActive = false, chordHoldRatio = 0, chordInDeadZone = false;
    if (chordHand) {
      chordPt = { x: chordHand[8].x * W, y: chordHand[8].y * H };
      const dx = chordPt.x - chordCenter.x, dy = chordPt.y - chordCenter.y;
      chordInDeadZone = Math.hypot(dx, dy) < radius * CENTER_DEAD_ZONE_RATIO;
      if (chordInDeadZone) {
        // Sustain the last committed chord quality through the transit,
        // same as the note wheel.
        chordHoverIdx = null;
        qualityLabel = lockedQuality;
        chordActive = true;
        setChord(48 + lockedRootPc, qualityLabel, CHORD_VOLUME);
      } else {
        const theta = Math.atan2(dy, dx);
        const idx = nearestSegment(theta, CHORD_SEGMENTS.length);
        qualityLabel = CHORD_SEGMENTS[idx];
        if (idx !== chordHoverIdx) { chordHoverIdx = idx; chordHoverSince = now; }
        chordHoldRatio = Math.min(1, (now - chordHoverSince) / DWELL_MS);
        chordActive = chordHoldRatio >= 1;
        if (chordActive) lockedQuality = qualityLabel;
        const rootMidi = 48 + lockedRootPc; // C3-based chord root
        setChord(rootMidi, qualityLabel, chordActive ? CHORD_VOLUME : 0);
      }
    } else {
      chordHoverIdx = null;
      setChord(48 + lockedRootPc, qualityLabel, 0);
    }

    // Chord color = blend of the colors of its actual notes (root + quality
    // intervals), recomputed live every time root or quality changes.
    const chordTones = CHORD_INTERVALS[qualityLabel].map(iv => (lockedRootPc + iv) % 12);
    const chordColor = blendColors(chordTones);
    const chordColorStr = rgbStr(chordColor);

    // ---- Draw note wheel ----
    // Active: bright — follows the chord's color while a chord is also
    // actively playing, to visually tie the note to the chord being built
    // from it. Still dwelling: same hue, dimmed. In the dead zone: falls
    // back to the last locked note/color instead of flickering.
    if (noteHand) {
      const displayPc = noteInDeadZone ? lockedRootPc : notePcs[noteIdx];
      const displayLabel = noteInDeadZone ? lockedRootLabel : noteLetter;
      const brightColor = chordHand && chordActive ? chordColorStr : rgbStr(pcColor(displayPc));
      const noteActiveColor = noteActive ? brightColor : rgbStr(pcColor(displayPc), 0.4);
      drawWheel(noteCenter.x, noteCenter.y, radius, noteSegments, displayLabel, notePt, noteActiveColor, noteSegmentColors);
      drawFingerIndicator(noteHand, noteActive, noteHoldRatio);
    } else {
      drawWheel(noteCenter.x, noteCenter.y, radius, noteSegments, 'MATI', null, '#fff', noteSegmentColors);
    }

    // ---- Draw chord wheel ----
    if (chordHand) {
      const chordDrawColor = chordActive ? chordColorStr : 'rgba(200,200,200,0.5)';
      drawWheel(chordCenter.x, chordCenter.y, radius, CHORD_SEGMENTS, qualityLabel, chordPt, chordDrawColor);
      drawFingerIndicator(chordHand, chordActive, chordHoldRatio);
    } else {
      drawWheel(chordCenter.x, chordCenter.y, radius, CHORD_SEGMENTS, qualityLabel, null, '#fff');
    }
  }

  // ---------------- Start flow ----------------
  const startBtn = document.getElementById('startBtn');
  const startScreen = document.getElementById('start');

  startBtn.addEventListener('click', async () => {
    try {
      initAudio();
      if (audioCtx.state === 'suspended') await audioCtx.resume();

      const HandsClass = await waitForGlobal('Hands', 8000);
      const CameraClass = await waitForGlobal('Camera', 8000);

      if (!hands) {
        hands = new HandsClass({
          locateFile: (file) => `https://cdn.jsdelivr.net/npm/@mediapipe/hands/${file}`
        });
        hands.setOptions({
          maxNumHands: 2,
          modelComplexity: 1,
          minDetectionConfidence: 0.6,
          minTrackingConfidence: 0.6
        });
        // A single malformed frame throwing inside handleHandResults could
        // otherwise abort MediaPipe's internal call chain and silently
        // stop all future onResults callbacks — catch and log instead of
        // letting one bad frame kill hand tracking for the rest of the
        // session.
        hands.onResults((results) => {
          try {
            handleHandResults(results);
          } catch (err) {
            console.error('Jari Nada: gagal memproses frame tangan', err);
          }
        });
      }

      const camera = new CameraClass(video, {
        onFrame: async () => {
          try {
            await hands.send({ image: video });
          } catch (err) {
            console.error('Jari Nada: gagal mengirim frame ke MediaPipe', err);
          }
        },
        width: 1280,
        height: 720
      });
      await camera.start();
      startScreen.style.display = 'none';
    } catch (err) {
      alert('Akses kamera gagal: ' + err.message);
      console.error(err);
    }
  });
})();
</script>
</body>
</html>
JARINADA_HTML;
        exit;
    }
});
