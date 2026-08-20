/**
 * ==========================================================================
 * CVIP LAB - INTERACTIVE JAVASCRIPT & NEURAL VISION ANIMATION
 * Computer Vision & Image Processing Research Laboratory
 * ==========================================================================
 */

document.addEventListener('DOMContentLoaded', () => {
  initTheme();
  initVisionCanvas();
  initFacultyCanvas();
  initResearchCanvas();
  initTeamCanvas();
  initProjectsCanvas();
  initPublicationsCanvas();
  initNewsCanvas();
  initContactCanvas();
  initMobileNav();
  initStudentFilters();
  initPublicationSearch();
  initModals();
});

/* ==========================================================================
   Interactive Neural Vision Canvas (Homepage: #vision-canvas)
   ========================================================================== */
function initVisionCanvas() {
  const canvas = document.getElementById('vision-canvas');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  let width, height;
  let particles = [];
  let mouse = { x: null, y: null, radius: 140 };

  function resize() {
    width = canvas.width = canvas.offsetWidth;
    height = canvas.height = canvas.offsetHeight;
  }

  window.addEventListener('resize', resize);
  resize();

  window.addEventListener('mousemove', (e) => {
    const rect = canvas.getBoundingClientRect();
    mouse.x = e.clientX - rect.left;
    mouse.y = e.clientY - rect.top;
  });

  window.addEventListener('mouseleave', () => {
    mouse.x = null;
    mouse.y = null;
  });

  const particleCount = Math.min(Math.floor((width * height) / 12000), 75);

  class Particle {
    constructor() {
      this.x = Math.random() * width;
      this.y = Math.random() * height;
      this.vx = (Math.random() - 0.5) * 0.9;
      this.vy = (Math.random() - 0.5) * 0.9;
      this.radius = Math.random() * 2.2 + 1.2;
      this.color = Math.random() > 0.4 ? '#38bdf8' : '#818cf8';
      this.isBoundingBox = Math.random() > 0.88;
      this.boxSize = Math.random() * 24 + 16;
    }

    update() {
      this.x += this.vx;
      this.y += this.vy;

      if (this.x < 0 || this.x > width) this.vx *= -1;
      if (this.y < 0 || this.y > height) this.vy *= -1;

      if (mouse.x !== null) {
        const dx = mouse.x - this.x;
        const dy = mouse.y - this.y;
        const dist = Math.sqrt(dx * dx + dy * dy);
        if (dist < mouse.radius) {
          const force = (mouse.radius - dist) / mouse.radius;
          this.x -= (dx / dist) * force * 3;
          this.y -= (dy / dist) * force * 3;
        }
      }
    }

    draw() {
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
      ctx.fillStyle = this.color;
      ctx.shadowBlur = 8;
      ctx.shadowColor = this.color;
      ctx.fill();
      ctx.shadowBlur = 0;

      if (this.isBoundingBox) {
        ctx.strokeStyle = 'rgba(56, 189, 248, 0.35)';
        ctx.lineWidth = 1;
        ctx.strokeRect(this.x - this.boxSize / 2, this.y - this.boxSize / 2, this.boxSize, this.boxSize);
        const s = 4;
        ctx.strokeStyle = '#38bdf8';
        ctx.beginPath();
        ctx.moveTo(this.x - this.boxSize/2, this.y - this.boxSize/2 + s);
        ctx.lineTo(this.x - this.boxSize/2, this.y - this.boxSize/2);
        ctx.lineTo(this.x - this.boxSize/2 + s, this.y - this.boxSize/2);
        ctx.stroke();
      }
    }
  }

  for (let i = 0; i < particleCount; i++) {
    particles.push(new Particle());
  }

  function animate() {
    ctx.clearRect(0, 0, width, height);

    for (let i = 0; i < particles.length; i++) {
      for (let j = i + 1; j < particles.length; j++) {
        const dx = particles[i].x - particles[j].x;
        const dy = particles[i].y - particles[j].y;
        const dist = Math.sqrt(dx * dx + dy * dy);

        if (dist < 130) {
          const alpha = (1 - dist / 130) * 0.25;
          ctx.strokeStyle = `rgba(56, 189, 248, ${alpha})`;
          ctx.lineWidth = 0.8;
          ctx.beginPath();
          ctx.moveTo(particles[i].x, particles[i].y);
          ctx.lineTo(particles[j].x, particles[j].y);
          ctx.stroke();
        }
      }
    }

    particles.forEach(p => {
      p.update();
      p.draw();
    });

    requestAnimationFrame(animate);
  }

  animate();
}

/* ==========================================================================
   1. FACULTY CANVAS: Dual-Core Synaptic Nebula (#canvas-faculty)
   ========================================================================== */
function initFacultyCanvas() {
  const canvas = document.getElementById('canvas-faculty');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  let width, height;
  let mouse = { x: null, y: null };
  let angle = 0;

  function resize() {
    width = canvas.width = canvas.offsetWidth;
    height = canvas.height = canvas.offsetHeight;
  }
  window.addEventListener('resize', resize);
  resize();

  window.addEventListener('mousemove', (e) => {
    const rect = canvas.getBoundingClientRect();
    mouse.x = e.clientX - rect.left;
    mouse.y = e.clientY - rect.top;
  });

  const nodes = [];
  for (let i = 0; i < 35; i++) {
    nodes.push({
      x: Math.random() * width,
      y: Math.random() * height,
      vx: (Math.random() - 0.5) * 0.7,
      vy: (Math.random() - 0.5) * 0.7,
      radius: Math.random() * 2 + 1,
      color: i % 2 === 0 ? '#38bdf8' : '#c084fc'
    });
  }

  function animate() {
    ctx.clearRect(0, 0, width, height);
    angle += 0.015;

    const core1 = { x: width * 0.3, y: height * 0.5 };
    const core2 = { x: width * 0.7, y: height * 0.5 };

    // Core 1 Pulsing Rings (Cyan)
    [30, 60, 90].forEach((r, idx) => {
      const currentR = r + Math.sin(angle + idx) * 8;
      ctx.beginPath();
      ctx.arc(core1.x, core1.y, currentR, 0, Math.PI * 2);
      ctx.strokeStyle = `rgba(56, 189, 248, ${0.25 - idx * 0.07})`;
      ctx.lineWidth = 1.2;
      ctx.stroke();
    });

    // Core 2 Pulsing Rings (Purple)
    [30, 60, 90].forEach((r, idx) => {
      const currentR = r + Math.cos(angle + idx) * 8;
      ctx.beginPath();
      ctx.arc(core2.x, core2.y, currentR, 0, Math.PI * 2);
      ctx.strokeStyle = `rgba(192, 132, 252, ${0.25 - idx * 0.07})`;
      ctx.lineWidth = 1.2;
      ctx.stroke();
    });

    // Connecting Synaptic Bridge between cores
    ctx.beginPath();
    ctx.moveTo(core1.x, core1.y);
    ctx.bezierCurveTo(
      width * 0.45, height * 0.3 + Math.sin(angle) * 20,
      width * 0.55, height * 0.7 + Math.cos(angle) * 20,
      core2.x, core2.y
    );
    ctx.strokeStyle = 'rgba(129, 140, 248, 0.4)';
    ctx.lineWidth = 2;
    ctx.stroke();

    // Floating Nodes
    nodes.forEach(n => {
      n.x += n.vx;
      n.y += n.vy;
      if (n.x < 0 || n.x > width) n.vx *= -1;
      if (n.y < 0 || n.y > height) n.vy *= -1;

      if (mouse.x !== null) {
        const dx = mouse.x - n.x;
        const dy = mouse.y - n.y;
        const d = Math.sqrt(dx * dx + dy * dy);
        if (d < 100) {
          n.x -= (dx / d) * 2;
          n.y -= (dy / d) * 2;
        }
      }

      ctx.beginPath();
      ctx.arc(n.x, n.y, n.radius, 0, Math.PI * 2);
      ctx.fillStyle = n.color;
      ctx.shadowBlur = 6;
      ctx.shadowColor = n.color;
      ctx.fill();
      ctx.shadowBlur = 0;

      // Connect to nearest core
      const targetCore = n.x < width / 2 ? core1 : core2;
      const distToCore = Math.sqrt((n.x - targetCore.x)**2 + (n.y - targetCore.y)**2);
      if (distToCore < 180) {
        ctx.beginPath();
        ctx.moveTo(n.x, n.y);
        ctx.lineTo(targetCore.x, targetCore.y);
        ctx.strokeStyle = `rgba(56, 189, 248, ${(1 - distToCore / 180) * 0.18})`;
        ctx.lineWidth = 0.6;
        ctx.stroke();
      }
    });

    requestAnimationFrame(animate);
  }
  animate();
}

/* ==========================================================================
   2. RESEARCH CANVAS: Holographic Laser Scanner Grid (#canvas-research)
   ========================================================================== */
function initResearchCanvas() {
  const canvas = document.getElementById('canvas-research');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  let width, height;
  let laserY = 0;
  let laserSpeed = 1.2;
  let mouse = { x: null, y: null };

  function resize() {
    width = canvas.width = canvas.offsetWidth;
    height = canvas.height = canvas.offsetHeight;
  }
  window.addEventListener('resize', resize);
  resize();

  window.addEventListener('mousemove', (e) => {
    const rect = canvas.getBoundingClientRect();
    mouse.x = e.clientX - rect.left;
    mouse.y = e.clientY - rect.top;
  });

  const scanBoxes = [
    { x: 0.2, y: 0.35, w: 90, h: 50, label: 'CNN: 99.4%', color: '#38bdf8' },
    { x: 0.6, y: 0.6, w: 110, h: 60, label: 'LLM MESH: ACTIVE', color: '#c084fc' },
    { x: 0.8, y: 0.3, w: 80, h: 45, label: 'TENSOR ACCEL', color: '#34d399' }
  ];

  function animate() {
    ctx.clearRect(0, 0, width, height);

    // Matrix Grid
    const gridSize = 45;
    ctx.strokeStyle = 'rgba(56, 189, 248, 0.06)';
    ctx.lineWidth = 1;
    for (let x = 0; x < width; x += gridSize) {
      ctx.beginPath();
      ctx.moveTo(x, 0);
      ctx.lineTo(x, height);
      ctx.stroke();
    }
    for (let y = 0; y < height; y += gridSize) {
      ctx.beginPath();
      ctx.moveTo(0, y);
      ctx.lineTo(width, y);
      ctx.stroke();
    }

    // Moving Laser Line
    laserY += laserSpeed;
    if (laserY > height || laserY < 0) laserSpeed *= -1;

    const grad = ctx.createLinearGradient(0, laserY - 15, 0, laserY + 15);
    grad.addColorStop(0, 'rgba(56, 189, 248, 0)');
    grad.addColorStop(0.5, 'rgba(56, 189, 248, 0.55)');
    grad.addColorStop(1, 'rgba(56, 189, 248, 0)');
    ctx.fillStyle = grad;
    ctx.fillRect(0, laserY - 15, width, 30);

    ctx.strokeStyle = '#38bdf8';
    ctx.lineWidth = 1.5;
    ctx.beginPath();
    ctx.moveTo(0, laserY);
    ctx.lineTo(width, laserY);
    ctx.stroke();

    // AI Bounding Boxes
    scanBoxes.forEach(b => {
      const bx = b.x * width;
      const by = b.y * height;
      ctx.strokeStyle = b.color;
      ctx.lineWidth = 1.2;
      ctx.strokeRect(bx, by, b.w, b.h);

      // Corner markers
      const s = 6;
      ctx.fillStyle = b.color;
      ctx.fillRect(bx - 2, by - 2, s, 2);
      ctx.fillRect(bx - 2, by - 2, 2, s);
      ctx.fillRect(bx + b.w - s + 2, by - 2, s, 2);
      ctx.fillRect(bx + b.w, by - 2, 2, s);

      ctx.font = '10px Fira Code, monospace';
      ctx.fillText(b.label, bx + 4, by - 6);
    });

    // Mouse Laser Crosshair
    if (mouse.x !== null) {
      ctx.strokeStyle = 'rgba(56, 189, 248, 0.4)';
      ctx.setLineDash([4, 4]);
      ctx.beginPath();
      ctx.moveTo(mouse.x, 0);
      ctx.lineTo(mouse.x, height);
      ctx.moveTo(0, mouse.y);
      ctx.lineTo(width, mouse.y);
      ctx.stroke();
      ctx.setLineDash([]);

      ctx.beginPath();
      ctx.arc(mouse.x, mouse.y, 25, 0, Math.PI * 2);
      ctx.strokeStyle = '#38bdf8';
      ctx.lineWidth = 1.2;
      ctx.stroke();
    }

    requestAnimationFrame(animate);
  }
  animate();
}

/* ==========================================================================
   3. TEAM CANVAS: Interactive Constellation of Minds (#canvas-team)
   ========================================================================== */
function initTeamCanvas() {
  const canvas = document.getElementById('canvas-team');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  let width, height;
  let mouse = { x: null, y: null, radius: 160 };

  function resize() {
    width = canvas.width = canvas.offsetWidth;
    height = canvas.height = canvas.offsetHeight;
  }
  window.addEventListener('resize', resize);
  resize();

  window.addEventListener('mousemove', (e) => {
    const rect = canvas.getBoundingClientRect();
    mouse.x = e.clientX - rect.left;
    mouse.y = e.clientY - rect.top;
  });

  const scholars = [];
  const colors = ['#a855f7', '#38bdf8', '#34d399', '#f59e0b'];

  for (let i = 0; i < 55; i++) {
    scholars.push({
      x: Math.random() * width,
      y: Math.random() * height,
      vx: (Math.random() - 0.5) * 0.8,
      vy: (Math.random() - 0.5) * 0.8,
      radius: Math.random() * 2.5 + 1.2,
      color: colors[i % colors.length],
      pulse: Math.random() * Math.PI
    });
  }

  function animate() {
    ctx.clearRect(0, 0, width, height);

    scholars.forEach(p => {
      p.x += p.vx;
      p.y += p.vy;
      p.pulse += 0.03;

      if (p.x < 0 || p.x > width) p.vx *= -1;
      if (p.y < 0 || p.y > height) p.vy *= -1;

      // Swirling Gravitational Pull
      if (mouse.x !== null) {
        const dx = mouse.x - p.x;
        const dy = mouse.y - p.y;
        const dist = Math.sqrt(dx * dx + dy * dy);
        if (dist < mouse.radius) {
          const force = (mouse.radius - dist) / mouse.radius;
          p.x += (dx / dist) * force * 1.8;
          p.y += (dy / dist) * force * 1.8;
        }
      }

      ctx.beginPath();
      const currentRadius = p.radius + Math.sin(p.pulse) * 0.8;
      ctx.arc(p.x, p.y, Math.max(0.5, currentRadius), 0, Math.PI * 2);
      ctx.fillStyle = p.color;
      ctx.shadowBlur = 8;
      ctx.shadowColor = p.color;
      ctx.fill();
      ctx.shadowBlur = 0;
    });

    // Constellation lines
    for (let i = 0; i < scholars.length; i++) {
      for (let j = i + 1; j < scholars.length; j++) {
        const dx = scholars[i].x - scholars[j].x;
        const dy = scholars[i].y - scholars[j].y;
        const dist = Math.sqrt(dx * dx + dy * dy);

        if (dist < 110) {
          ctx.beginPath();
          ctx.moveTo(scholars[i].x, scholars[i].y);
          ctx.lineTo(scholars[j].x, scholars[j].y);
          ctx.strokeStyle = `rgba(56, 189, 248, ${(1 - dist / 110) * 0.22})`;
          ctx.lineWidth = 0.7;
          ctx.stroke();
        }
      }
    }

    requestAnimationFrame(animate);
  }
  animate();
}

/* ==========================================================================
   4. PROJECTS CANVAS: Cybernetic Microchip Traces (#canvas-projects)
   ========================================================================== */
function initProjectsCanvas() {
  const canvas = document.getElementById('canvas-projects');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  let width, height;

  function resize() {
    width = canvas.width = canvas.offsetWidth;
    height = canvas.height = canvas.offsetHeight;
  }
  window.addEventListener('resize', resize);
  resize();

  const packets = [];
  for (let i = 0; i < 24; i++) {
    packets.push({
      x: Math.random() * width,
      y: Math.random() * height,
      speed: Math.random() * 2 + 1.2,
      axis: Math.random() > 0.5 ? 'x' : 'y',
      dir: Math.random() > 0.5 ? 1 : -1,
      color: Math.random() > 0.5 ? '#38bdf8' : '#34d399',
      size: Math.random() * 4 + 3
    });
  }

  function animate() {
    ctx.clearRect(0, 0, width, height);

    // Grid Circuit traces
    ctx.strokeStyle = 'rgba(56, 189, 248, 0.08)';
    ctx.lineWidth = 1;
    const spacing = 60;

    for (let x = 0; x < width; x += spacing) {
      ctx.beginPath();
      ctx.moveTo(x, 0);
      ctx.lineTo(x, height);
      ctx.stroke();

      // Solder dots
      for (let y = 0; y < height; y += spacing) {
        ctx.fillStyle = 'rgba(56, 189, 248, 0.2)';
        ctx.fillRect(x - 2, y - 2, 4, 4);
      }
    }

    // Moving Data Packets
    packets.forEach(p => {
      if (p.axis === 'x') {
        p.x += p.speed * p.dir;
        if (p.x > width || p.x < 0) {
          p.dir *= -1;
          if (Math.random() > 0.6) p.axis = 'y';
        }
      } else {
        p.y += p.speed * p.dir;
        if (p.y > height || p.y < 0) {
          p.dir *= -1;
          if (Math.random() > 0.6) p.axis = 'x';
        }
      }

      ctx.beginPath();
      ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
      ctx.fillStyle = p.color;
      ctx.shadowBlur = 10;
      ctx.shadowColor = p.color;
      ctx.fill();
      ctx.shadowBlur = 0;
    });

    requestAnimationFrame(animate);
  }
  animate();
}

/* ==========================================================================
   5. PUBLICATIONS CANVAS: Scientific Math Matrix (#canvas-publications)
   ========================================================================== */
function initPublicationsCanvas() {
  const canvas = document.getElementById('canvas-publications');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  let width, height;
  let mouse = { x: null, y: null };

  function resize() {
    width = canvas.width = canvas.offsetWidth;
    height = canvas.height = canvas.offsetHeight;
  }
  window.addEventListener('resize', resize);
  resize();

  window.addEventListener('mousemove', (e) => {
    const rect = canvas.getBoundingClientRect();
    mouse.x = e.clientX - rect.left;
    mouse.y = e.clientY - rect.top;
  });

  const glyphs = ['Σ', '∫', '∇', 'λ', 'μ', 'Ω', 'θ', '∂', 'Ψ', 'f(x)', 'E=mc²', 'W·x+b'];
  const symbols = [];

  for (let i = 0; i < 35; i++) {
    symbols.push({
      text: glyphs[i % glyphs.length],
      x: Math.random() * width,
      y: Math.random() * height,
      vy: Math.random() * 0.5 + 0.2,
      vx: (Math.random() - 0.5) * 0.3,
      size: Math.random() * 8 + 12,
      opacity: Math.random() * 0.4 + 0.2,
      color: i % 3 === 0 ? '#38bdf8' : (i % 3 === 1 ? '#c084fc' : '#818cf8')
    });
  }

  function animate() {
    ctx.clearRect(0, 0, width, height);

    symbols.forEach(s => {
      s.y -= s.vy;
      s.x += s.vx;

      if (s.y < -20) s.y = height + 20;
      if (s.x < 0 || s.x > width) s.vx *= -1;

      // Mouse Proximity Glow
      let scale = 1;
      let alpha = s.opacity;
      if (mouse.x !== null) {
        const dx = mouse.x - s.x;
        const dy = mouse.y - s.y;
        const d = Math.sqrt(dx * dx + dy * dy);
        if (d < 120) {
          scale = 1.3;
          alpha = 0.9;
        }
      }

      ctx.font = `${s.size * scale}px 'Fira Code', monospace`;
      ctx.fillStyle = s.color;
      ctx.globalAlpha = alpha;
      ctx.fillText(s.text, s.x, s.y);
      ctx.globalAlpha = 1.0;
    });

    requestAnimationFrame(animate);
  }
  animate();
}

/* ==========================================================================
   6. NEWS CANVAS: Broadcast Radar & Waveform (#canvas-news)
   ========================================================================== */
function initNewsCanvas() {
  const canvas = document.getElementById('canvas-news');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  let width, height;
  let waveOffset = 0;

  function resize() {
    width = canvas.width = canvas.offsetWidth;
    height = canvas.height = canvas.offsetHeight;
  }
  window.addEventListener('resize', resize);
  resize();

  const radars = [
    { x: 0.2, y: 0.5, r: 10, maxR: 180, speed: 0.8 },
    { x: 0.8, y: 0.4, r: 40, maxR: 200, speed: 0.9 }
  ];

  function animate() {
    ctx.clearRect(0, 0, width, height);
    waveOffset += 0.04;

    // Expanding Radar Ripples
    radars.forEach(rd => {
      rd.r += rd.speed;
      if (rd.r > rd.maxR) rd.r = 5;

      const rx = rd.x * width;
      const ry = rd.y * height;
      const alpha = (1 - rd.r / rd.maxR) * 0.4;

      ctx.beginPath();
      ctx.arc(rx, ry, rd.r, 0, Math.PI * 2);
      ctx.strokeStyle = `rgba(56, 189, 248, ${alpha})`;
      ctx.lineWidth = 1.4;
      ctx.stroke();

      // Radar Beacon Center
      ctx.beginPath();
      ctx.arc(rx, ry, 4, 0, Math.PI * 2);
      ctx.fillStyle = '#38bdf8';
      ctx.fill();
    });

    // Sine Waveforms
    ctx.beginPath();
    ctx.strokeStyle = 'rgba(129, 140, 248, 0.22)';
    ctx.lineWidth = 1.5;
    for (let x = 0; x < width; x += 5) {
      const y = height * 0.7 + Math.sin(x * 0.015 + waveOffset) * 22;
      if (x === 0) ctx.moveTo(x, y);
      else ctx.lineTo(x, y);
    }
    ctx.stroke();

    requestAnimationFrame(animate);
  }
  animate();
}

/* ==========================================================================
   7. CONTACT CANVAS: 3D Geodesic Coordinate Globe (#canvas-contact)
   ========================================================================== */
function initContactCanvas() {
  const canvas = document.getElementById('canvas-contact');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  let width, height;
  let rot = 0;
  let mouse = { x: null, y: null };

  function resize() {
    width = canvas.width = canvas.offsetWidth;
    height = canvas.height = canvas.offsetHeight;
  }
  window.addEventListener('resize', resize);
  resize();

  window.addEventListener('mousemove', (e) => {
    const rect = canvas.getBoundingClientRect();
    mouse.x = e.clientX - rect.left;
    mouse.y = e.clientY - rect.top;
  });

  function animate() {
    ctx.clearRect(0, 0, width, height);
    rot += 0.008;

    const cx = width * 0.5;
    const cy = height * 0.5;
    const globeRadius = Math.min(width, height) * 0.38;

    // Outer Glow Ring
    ctx.beginPath();
    ctx.arc(cx, cy, globeRadius, 0, Math.PI * 2);
    ctx.strokeStyle = 'rgba(56, 189, 248, 0.25)';
    ctx.lineWidth = 1.2;
    ctx.stroke();

    // Rotating Longitude Ellipses
    for (let i = 0; i < 6; i++) {
      const curAngle = rot + (i * Math.PI) / 6;
      const w = Math.cos(curAngle) * globeRadius;

      ctx.beginPath();
      ctx.ellipse(cx, cy, Math.abs(w), globeRadius, 0, 0, Math.PI * 2);
      ctx.strokeStyle = 'rgba(56, 189, 248, 0.12)';
      ctx.lineWidth = 1;
      ctx.stroke();
    }

    // Latitude Rings
    [-0.6, -0.3, 0, 0.3, 0.6].forEach(offset => {
      const latY = cy + offset * globeRadius;
      const latR = Math.sqrt(globeRadius**2 - (offset * globeRadius)**2);

      ctx.beginPath();
      ctx.ellipse(cx, latY, latR, latR * 0.3, 0, 0, Math.PI * 2);
      ctx.strokeStyle = 'rgba(129, 140, 248, 0.14)';
      ctx.lineWidth = 1;
      ctx.stroke();
    });

    // Orbiting Satellite Beacon
    const satAngle = rot * 2.5;
    const sx = cx + Math.cos(satAngle) * (globeRadius + 20);
    const sy = cy + Math.sin(satAngle) * ((globeRadius + 20) * 0.45);

    ctx.beginPath();
    ctx.arc(sx, sy, 4, 0, Math.PI * 2);
    ctx.fillStyle = '#38bdf8';
    ctx.shadowBlur = 10;
    ctx.shadowColor = '#38bdf8';
    ctx.fill();
    ctx.shadowBlur = 0;

    requestAnimationFrame(animate);
  }
  animate();
}

/* ==========================================================================
   Mobile Navigation & Drawer
   ========================================================================== */
function initMobileNav() {
  const toggle = document.querySelector('.mobile-toggle');
  const menu = document.querySelector('.nav-menu');

  if (toggle && menu) {
    toggle.addEventListener('click', (e) => {
      e.stopPropagation();
      const isActive = menu.classList.toggle('active');
      toggle.innerHTML = isActive ? '✕' : '☰';
    });

    document.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', () => {
        menu.classList.remove('active');
        if (toggle) toggle.innerHTML = '☰';
      });
    });

    // Close when clicking outside
    document.addEventListener('click', (e) => {
      if (menu.classList.contains('active') && !menu.contains(e.target) && !toggle.contains(e.target)) {
        menu.classList.remove('active');
        if (toggle) toggle.innerHTML = '☰';
      }
    });

    // Escape key closes menu and modals
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        menu.classList.remove('active');
        if (toggle) toggle.innerHTML = '☰';
        document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('active'));
      }
    });
  }
}

/* ==========================================================================
   Live Student Search & Tab Filter
   ========================================================================== */
function initStudentFilters() {
  const tabs = document.querySelectorAll('.student-filter-tab');
  const searchInput = document.getElementById('student-search-input');
  const cards = document.querySelectorAll('.student-card-item');

  if (!cards.length) return;

  let currentCategory = 'all';
  let currentSearch = '';

  function filterCards() {
    let visibleCount = 0;

    cards.forEach(card => {
      const category = (card.getAttribute('data-degree') || '').toLowerCase();
      const isAlumni = card.getAttribute('data-graduated') === '1' || 
                       card.getAttribute('data-graduated') === 'true' || 
                       category === 'alumni';
      
      const searchAttr = (card.getAttribute('data-search') || '').toLowerCase();
      const cardText = card.textContent.toLowerCase();
      const combinedSearch = searchAttr + ' ' + cardText;

      let categoryMatch = false;
      if (currentCategory === 'all') {
        categoryMatch = true;
      } else if (currentCategory === 'phd') {
        categoryMatch = (category === 'phd' || category.includes('phd')) && !isAlumni;
      } else if (currentCategory === 'msc') {
        categoryMatch = (category === 'msc' || category.includes('msc')) && !isAlumni;
      } else if (currentCategory === 'alumni') {
        categoryMatch = isAlumni || category === 'alumni';
      }

      const searchMatch = !currentSearch || combinedSearch.includes(currentSearch);

      if (categoryMatch && searchMatch) {
        card.style.display = 'flex';
        visibleCount++;
      } else {
        card.style.display = 'none';
      }
    });

    const noResults = document.getElementById('no-students-msg');
    if (noResults) {
      noResults.style.display = visibleCount === 0 ? 'block' : 'none';
    }
  }

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      currentCategory = tab.getAttribute('data-filter') || 'all';
      filterCards();
    });
  });

  if (searchInput) {
    searchInput.addEventListener('input', (e) => {
      currentSearch = e.target.value.trim().toLowerCase();
      filterCards();
    });
  }
}

/* ==========================================================================
   Publications Search & Filter
   ========================================================================== */
function initPublicationSearch() {
  const searchInput = document.getElementById('pub-search-input');
  const pubItems = document.querySelectorAll('.pub-item');

  if (!searchInput || !pubItems.length) return;

  searchInput.addEventListener('input', (e) => {
    const q = e.target.value.trim().toLowerCase();
    let count = 0;

    pubItems.forEach(item => {
      const text = item.textContent.toLowerCase();
      if (!q || text.includes(q)) {
        item.style.display = 'flex';
        count++;
      } else {
        item.style.display = 'none';
      }
    });

    const emptyMsg = document.getElementById('no-pubs-msg');
    if (emptyMsg) {
      emptyMsg.style.display = count === 0 ? 'block' : 'none';
    }
  });
}

/* ==========================================================================
   Modals & BibTeX Exporter
   ========================================================================== */
function initModals() {
  // BibTeX Modal
  const bibtexBtns = document.querySelectorAll('.btn-bibtex');
  const bibtexModal = document.getElementById('bibtex-modal');
  const bibtexCode = document.getElementById('bibtex-content');
  const copyBtn = document.getElementById('btn-copy-bibtex');

  if (bibtexBtns.length && bibtexModal && bibtexCode) {
    bibtexBtns.forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const bib = btn.getAttribute('data-bibtex') || '';
        bibtexCode.textContent = bib;
        bibtexModal.classList.add('active');
      });
    });

    if (copyBtn) {
      copyBtn.addEventListener('click', () => {
        navigator.clipboard.writeText(bibtexCode.textContent).then(() => {
          const orig = copyBtn.innerHTML;
          copyBtn.innerHTML = '✓ Copied!';
          setTimeout(() => { copyBtn.innerHTML = orig; }, 2000);
        });
      });
    }
  }

  // Close Modals on close-button or backdrop click
  document.querySelectorAll('.modal-close, .modal-overlay').forEach(el => {
    el.addEventListener('click', (e) => {
      if (e.target === el || e.target.classList.contains('modal-close')) {
        document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('active'));
      }
    });
  });

  initAdminModal();
}

/* ==========================================================================
   Interactive Admin Modal CMS & Simulator
   ========================================================================== */
function initAdminModal() {
  if (!document.getElementById('admin-modal')) {
    const adminModalHtml = `
    <div class="modal-overlay" id="admin-modal">
      <div class="modal-card" style="max-width: 780px; width: 94%;">
        <button class="modal-close" type="button">✕</button>
        
        <div id="admin-login-view">
          <div style="text-align: center; margin-bottom: 24px;">
            <div style="font-size: 2.6rem; margin-bottom: 8px;">🔐</div>
            <h2 style="font-size: 1.6rem; color: var(--text-primary); margin-bottom: 6px;">ورود به پنل مدیریت آزمایشگاه</h2>
            <p style="color: var(--text-muted); font-size: 0.9rem;">نام کاربری: <code>admin</code> | رمز عبور: <code>admin123</code></p>
          </div>

          <div id="admin-login-err" style="display: none; background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #f87171; padding: 12px; border-radius: 8px; margin-bottom: 16px; text-align: center; font-size: 0.9rem;">
            نام کاربری یا رمز عبور اشتباه است!
          </div>

          <form id="admin-login-form" onsubmit="handleAdminLogin(event)">
            <div class="form-group" style="margin-bottom: 16px;">
              <label class="form-label" style="display: block; margin-bottom: 6px; font-weight: 600;">نام کاربری (Username)</label>
              <input type="text" id="adm-user" class="form-control" style="width: 100%; padding: 12px; background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: 8px; color: #fff;" value="admin" required>
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
              <label class="form-label" style="display: block; margin-bottom: 6px; font-weight: 600;">رمز عبور (Password)</label>
              <input type="password" id="adm-pass" class="form-control" style="width: 100%; padding: 12px; background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: 8px; color: #fff;" value="admin123" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-weight: 700;">
              ورود به سیستم (Sign In)
            </button>
          </form>
        </div>

        <div id="admin-dash-view" style="display: none;">
          <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 16px; margin-bottom: 20px;">
            <div>
              <h2 style="font-size: 1.4rem; color: var(--text-primary);">📊 پیشخوان مدیریت پرتال (Admin CMS)</h2>
              <p style="font-size: 0.85rem; color: var(--text-muted);">خوش آمدید، مدیر سیستم | دسترسی به مدیریت اساتید، دانشجویان و مقالات</p>
            </div>
            <button type="button" class="btn btn-outline btn-sm" onclick="handleAdminLogout()">🚪 خروج</button>
          </div>

          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 12px; margin-bottom: 20px;">
            <div style="background: var(--bg-primary); border: 1px solid var(--border-color); padding: 14px; border-radius: 8px; text-align: center;">
              <div style="font-size: 1.6rem; font-weight: 800; color: var(--accent-cyan);">35</div>
              <div style="font-size: 0.78rem; color: var(--text-muted);">کل پژوهشگران</div>
            </div>
            <div style="background: var(--bg-primary); border: 1px solid var(--border-color); padding: 14px; border-radius: 8px; text-align: center;">
              <div style="font-size: 1.6rem; font-weight: 800; color: var(--accent-purple);">9</div>
              <div style="font-size: 0.78rem; color: var(--text-muted);">دانشجوی دکتری</div>
            </div>
            <div style="background: var(--bg-primary); border: 1px solid var(--border-color); padding: 14px; border-radius: 8px; text-align: center;">
              <div style="font-size: 1.6rem; font-weight: 800; color: var(--accent-blue);">22</div>
              <div style="font-size: 0.78rem; color: var(--text-muted);">دانشجوی ارشد</div>
            </div>
            <div style="background: var(--bg-primary); border: 1px solid var(--border-color); padding: 14px; border-radius: 8px; text-align: center;">
              <div style="font-size: 1.6rem; font-weight: 800; color: var(--accent-emerald);">4</div>
              <div style="font-size: 0.78rem; color: var(--text-muted);">فارغ‌التحصیل</div>
            </div>
          </div>

          <div style="margin-bottom: 16px; display: flex; gap: 8px; flex-wrap: wrap;">
            <button type="button" class="btn btn-primary btn-sm" onclick="alert('فرم افزودن دانشجو در نسخه پایگاه‌داده فعال است.')">➕ افزودن دانشجو</button>
            <button type="button" class="btn btn-secondary btn-sm" onclick="alert('فرم افزودن مقاله در نسخه پایگاه‌داده فعال است.')">📚 ثبت مقاله جدید</button>
            <a href="team.html" class="btn btn-outline btn-sm">👥 مدیریت اعضا</a>
          </div>

          <div style="max-height: 240px; overflow-y: auto; border: 1px solid var(--border-color); border-radius: 8px;">
            <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem; text-align: right;">
              <thead>
                <tr style="background: var(--bg-primary); border-bottom: 1px solid var(--border-color);">
                  <th style="padding: 10px;">نام پژوهشگر</th>
                  <th style="padding: 10px;">مقطع</th>
                  <th style="padding: 10px;">استاد راهنما</th>
                </tr>
              </thead>
              <tbody>
                <tr style="border-bottom: 1px solid var(--border-color);"><td style="padding: 10px; font-weight: 600;">فائزه صفری</td><td style="padding: 10px;">PhD</td><td style="padding: 10px; color: var(--accent-cyan);">دکتر عبدالله چاله چاله</td></tr>
                <tr style="border-bottom: 1px solid var(--border-color);"><td style="padding: 10px; font-weight: 600;">عارف عارف‌نیا</td><td style="padding: 10px;">PhD</td><td style="padding: 10px; color: var(--accent-cyan);">دکتر عبدالله چاله چاله</td></tr>
                <tr style="border-bottom: 1px solid var(--border-color);"><td style="padding: 10px; font-weight: 600;">طاهره کرمی</td><td style="padding: 10px;">PhD</td><td style="padding: 10px; color: var(--accent-cyan);">دکتر عبدالله چاله چاله</td></tr>
                <tr style="border-bottom: 1px solid var(--border-color);"><td style="padding: 10px; font-weight: 600;">سمانه خسروی</td><td style="padding: 10px;">PhD</td><td style="padding: 10px; color: var(--accent-cyan);">دکتر آرزو کامران</td></tr>
                <tr style="border-bottom: 1px solid var(--border-color);"><td style="padding: 10px; font-weight: 600;">فاطمه خلوندی</td><td style="padding: 10px;">MSc</td><td style="padding: 10px; color: var(--accent-cyan);">دکتر عبدالله چاله چاله</td></tr>
                <tr style="border-bottom: 1px solid var(--border-color);"><td style="padding: 10px; font-weight: 600;">طیبه کریمی</td><td style="padding: 10px;">Alumni</td><td style="padding: 10px; color: var(--accent-cyan);">دکتر آرزو کامران</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    `;
    document.body.insertAdjacentHTML('beforeend', adminModalHtml);
  }

  // Bind close buttons again
  const adminModal = document.getElementById('admin-modal');
  if (adminModal) {
    adminModal.querySelectorAll('.modal-close').forEach(b => {
      b.addEventListener('click', () => adminModal.classList.remove('active'));
    });
    adminModal.addEventListener('click', (e) => {
      if (e.target === adminModal) adminModal.classList.remove('active');
    });
  }
}

// Global functions accessible via onclick
window.openAdminModal = function() {
  initAdminModal();
  const modal = document.getElementById('admin-modal');
  if (modal) {
    modal.classList.add('active');
  }
};

window.handleAdminLogin = function(e) {
  if (e) e.preventDefault();
  const user = document.getElementById('adm-user')?.value.trim();
  const pass = document.getElementById('adm-pass')?.value.trim();
  const err = document.getElementById('admin-login-err');

  if (user === 'admin' && pass === 'admin123') {
    if (err) err.style.display = 'none';
    const loginView = document.getElementById('admin-login-view');
    const dashView = document.getElementById('admin-dash-view');
    if (loginView) loginView.style.display = 'none';
    if (dashView) dashView.style.display = 'block';
  } else {
    if (err) err.style.display = 'block';
  }
};

window.handleAdminLogout = function() {
  const loginView = document.getElementById('admin-login-view');
  const dashView = document.getElementById('admin-dash-view');
  if (dashView) dashView.style.display = 'none';
  if (loginView) loginView.style.display = 'block';
};

