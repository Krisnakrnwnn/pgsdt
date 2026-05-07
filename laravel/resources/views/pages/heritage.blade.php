@extends('layouts.app')

@section('title', 'Sejarah & Warisan - Para Gotra Santana Dalem Tarukan')
@section('meta_description', 'Menelusuri jejak sejarah Ida Bhatara Dalem Tarukan, dari kejayaan Samprangan hingga kehidupan spiritual di Pulasari. Warisan luhur krama PGSDT.')

@section('content')
    <!-- HERO SECTION -->
    <section class="hero hero-fullscreen" style="background-image: url('{{ asset('assets/heritage_1.png') }}'); background-attachment: fixed; background-color: var(--primary-dark);">
        <div class="hero-content" data-aos="zoom-out" data-aos-duration="1500">
            <span class="badge" style="margin-bottom: 10px;">Jejak Leluhur</span>
            <h1 style="font-family: 'Cinzel Decorative', serif; font-size: clamp(2.5rem, 10vw, 5rem); margin-bottom: 20px; text-shadow: 0 4px 20px rgba(0,0,0,0.5);">Babad Dalem Tarukan</h1>
            <div style="width: 100px; height: 2px; background: var(--accent-gold); margin: 0 auto 30px;"></div>
            <p style="font-size: clamp(1rem, 2vw, 1.4rem); letter-spacing: 4px; color: var(--accent-gold-light);">Melestarikan Nilai Luhur Santana</p>
        </div>
        <div style="position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); color: white; animation: bounce 2s infinite; z-index: 2;">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </div>
    </section>

    <!-- INTRODUCTION -->
    <section style="padding: 100px 0; background: var(--section-bg); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -50px; left: -50px; opacity: 0.03; font-family: 'Cinzel', serif; font-size: 20rem; pointer-events: none;">HISTORIA</div>
        <div class="container" style="max-width: 900px; margin: 0 auto; padding: 0 20px; text-align: center;">
            <div data-aos="fade-up">
                <h2 style="font-family: 'Cinzel', serif; font-size: 2rem; color: var(--primary-dark); margin-bottom: 40px; letter-spacing: 2px;">Sang Pangeran Yang Merakyat</h2>
                <div style="font-size: 1.15rem; line-height: 2; color: #444; text-align: justify; border-left: 3px solid var(--accent-gold); padding-left: 30px;">
                    <p>
                        Sejarah <strong>Para Gotra Santana Dalem Tarukan (PGSDT)</strong> berakar dari kisah perjalanan hidup <strong>Ida Dalem Tarukan</strong>, putra kedua dari Raja Bali pertama era Majapahit, <strong>Ida Dalem Ketut Kresna Kepakisan</strong>. Beliau adalah sosok yang lebih memilih jalan spiritual dan kedekatan dengan rakyat dibandingkan kemegahan tahta kekuasaan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- TIMELINE / CHAPTERS -->
    
    <!-- Chapter 1: Samprangan -->
    <section style="padding: 80px 0; background: white;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 40px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;">
                <div data-aos="fade-right">
                    <span style="color: var(--accent-gold); font-weight: 700; letter-spacing: 2px; font-size: 0.8rem;">BAB I: ASAL USUL</span>
                    <h3 style="font-size: 2.5rem; margin: 20px 0; color: var(--primary-dark);">Masa Kejayaan Samprangan</h3>
                    <p style="color: #666; margin-bottom: 25px; line-height: 1.8;">
                        Ida Dalem Tarukan lahir di Puri Samprangan, Gianyar. Beliau merupakan adik kandung dari Dalem Agra Samprangan dan memiliki saudara lainnya seperti Dewa Ayu Swabawa, Dalem Ketut Ngulesir, dan I Dewa Tegal Besung. Beliau kemudian membangun kediaman sendiri di <strong>Tarukan, Pejeng</strong>.
                    </p>
                    <div style="background: var(--section-bg); padding: 25px; border-radius: 4px; border-left: 4px solid var(--accent-gold);">
                        <em style="color: var(--primary-dark); font-weight: 500;">"Beliau dikenal sebagai ksatria yang sangat setia pada janji dan memiliki jiwa spiritual yang dalam."</em>
                    </div>
                </div>
                <div data-aos="fade-left" style="position: relative;">
                    <img src="{{ asset('assets/heritage_1.png') }}" alt="Samprangan Era" style="width: 100%; border-radius: 4px; box-shadow: 20px 20px 0 var(--section-bg); border: 1px solid #eee;">
                </div>
            </div>
        </div>
    </section>

    <!-- Chapter 2: The Tragedy -->
    <section style="padding: 100px 0; background: var(--primary-dark); color: white;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 40px;">
            <div style="text-align: center; max-width: 800px; margin: 0 auto 80px;" data-aos="fade-up">
                <span style="color: var(--accent-gold); font-weight: 700; letter-spacing: 2px; font-size: 0.8rem;">BAB II: TRAGEDI & JANJI</span>
                <h3 style="font-size: 2.5rem; margin: 20px 0; color: white;">Konflik Keris Ki Tanda Langlang</h3>
                <p style="color: #aaa; line-height: 1.8;">
                    Konflik besar bermula saat Ida Dalem Tarukan berjanji menjodohkan putra angkatnya, <strong>Rakriyan Kuda Penandang Kajar</strong>, dengan putri Dalem Agra Samprangan, <strong>Dewa Ayu Muter</strong>. Janji yang ditepati tanpa restu raja ini memicu kemarahan besar di istana.
                </p>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;">
                <div data-aos="fade-up" data-aos-delay="200">
                    <img src="{{ asset('assets/heritage_2.png') }}" alt="Pelarian" style="width: 100%; border-radius: 4px; filter: sepia(0.2) contrast(1.1);">
                </div>
                <div data-aos="fade-up" data-aos-delay="400">
                    <p style="margin-bottom: 25px; line-height: 1.8; color: #ddd;">
                        Tragedi berdarah tersebut berakhir dengan tewasnya Kuda Penandang Kajar dan Dewa Ayu Muter oleh kesaktian keris pusaka <strong>Ki Tanda Langlang</strong>. Peristiwa ini memaksa Ida Dalem Tarukan untuk meninggalkan istananya dan menjalani hidup dalam pelarian (lelana) demi menjaga keselamatan keturunan beliau.
                    </p>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 15px; display: flex; align-items: flex-start; gap: 15px;">
                            <span style="color: var(--accent-gold); font-size: 1.5rem;">•</span>
                            <span>Menghindari konflik saudara demi kerukunan jagat Bali.</span>
                        </li>
                        <li style="margin-bottom: 15px; display: flex; align-items: flex-start; gap: 15px;">
                            <span style="color: var(--accent-gold); font-size: 1.5rem;">•</span>
                            <span>Memulai perjalanan spiritual menyatu dengan alam dan rakyat jelata.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Chapter 3: Pulesari -->
    <section style="padding: 100px 0; background: white;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 40px;">
            <div style="display: grid; grid-template-columns: 1fr 1.2fr; gap: 60px; align-items: center;">
                <div data-aos="fade-right">
                    <span style="color: var(--accent-gold); font-weight: 700; letter-spacing: 2px; font-size: 0.8rem;">BAB III: PULESARI</span>
                    <h3 style="font-size: 2.5rem; margin: 20px 0; color: var(--primary-dark);">Pelabuhan Terakhir di Bangli</h3>
                    <p style="color: #666; margin-bottom: 25px; line-height: 1.8;">
                        Setelah bertahun-tahun berpindah tempat, Ida Dalem Tarukan akhirnya menetap di <strong>Pulesari, Desa Peninjoan, Bangli</strong>. Di tempat yang sunyi dan sejuk inilah beliau menjalani sisa hidupnya sebagai seorang <em>Sulinggih</em> atau pendeta yang dihormati.
                    </p>
                    <p style="color: #666; line-height: 1.8;">
                        Hingga kini, Pulesari menjadi lokasi berdirinya <strong>Pura Padharman Pusat Ida Bhatara Dalem Tarukan</strong>, tempat suci bagi seluruh pratisentana (keturunan) beliau yang tersebar di seluruh Nusantara untuk memuja leluhur.
                    </p>
                </div>
                <div data-aos="fade-left">
                    <div style="position: relative; padding: 20px; background: var(--section-bg); border-radius: 8px;">
                        <img src="{{ asset('assets/heritage_3.png') }}" alt="Pura Pulesari" style="width: 100%; border-radius: 4px;">
                        <div style="position: absolute; top: -10px; right: -10px; background: var(--accent-gold); color: var(--primary-dark); padding: 15px 25px; font-weight: 800; font-family: 'Cinzel', serif;">PENINJOAN, BANGLI</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Chapter 4: PGSDT -->
    <section style="padding: 100px 0; background: var(--section-bg);">
        <div class="container" style="max-width: 900px; margin: 0 auto; padding: 0 20px; text-align: center;">
            <div data-aos="zoom-in">
                <span style="color: var(--accent-gold); font-weight: 700; letter-spacing: 2px; font-size: 0.8rem;">ERA MODERN</span>
                <h3 style="font-size: 2.5rem; margin: 20px 0; color: var(--primary-dark);">Lahirnya Organisasi PGSDT</h3>
                <p style="color: #555; line-height: 2; font-size: 1.1rem; margin-bottom: 40px;">
                    Untuk menyatukan seluruh keluarga besar keturunan Ida Dalem Tarukan, maka pada tanggal <strong>23 Maret 1969</strong>, dibentuklah secara resmi organisasi <strong>Para Gotra Santana Dalem Tarukan (PGSDT)</strong>. Organisasi ini menjadi wadah pemersatu, pelestari silsilah, dan penjaga nilai-nilai luhur leluhur bagi jutaan krama di seluruh dunia.
                </p>
                <div style="display: flex; justify-content: center; gap: 30px; flex-wrap: wrap;">
                    <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); min-width: 200px;">
                        <div style="color: var(--accent-gold); font-size: 2.5rem; font-weight: 800; font-family: 'Cinzel', serif;">1969</div>
                        <div style="font-size: 0.8rem; letter-spacing: 1px; text-transform: uppercase; font-weight: 700; color: #888;">Tahun Berdiri</div>
                    </div>
                    <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); min-width: 200px;">
                        <div style="color: var(--accent-gold); font-size: 2.5rem; font-weight: 800; font-family: 'Cinzel', serif;">PUSAT</div>
                        <div style="font-size: 0.8rem; letter-spacing: 1px; text-transform: uppercase; font-weight: 700; color: #888;">Pulesari, Bangli</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER CTA -->
    <section style="padding: 80px 0; background: var(--accent-gold); text-align: center;">
        <div class="container" data-aos="fade-up">
            <h2 style="font-family: 'Cinzel', serif; color: var(--primary-dark); margin-bottom: 30px;">Mari Lestarikan Sejarah Kita</h2>
            <p style="color: var(--primary-dark); opacity: 0.8; max-width: 600px; margin: 0 auto 40px; font-weight: 500;">Jika Anda memiliki salinan Babad, Lontar, atau foto bersejarah keluarga, silakan hubungi kami untuk digitalisasi.</p>
            <a href="mailto:pgsdtpusat1969@gmail.com" class="btn-primary" style="background: var(--primary-dark); color: var(--accent-gold); border: none;">KIRIM DOKUMENTASI</a>
        </div>
    </section>

    <!-- REFERENCES SECTION -->
    <section style="padding: 80px 0; background: white;">
        <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 0 40px;">
            <div style="border-top: 1px solid #eee; padding-top: 50px;">
                <h3 style="font-family: 'Cinzel', serif; font-size: 1.5rem; color: var(--primary-dark); margin-bottom: 30px; display: flex; align-items: center; gap: 15px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 24px; height: 24px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.247 18.477 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Referensi & Sumber Akademik
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                    <ul style="list-style: none; padding: 0; color: #666; font-size: 0.95rem; line-height: 1.8;">
                        <li style="margin-bottom: 12px; display: flex; gap: 10px;"><span style="color: var(--accent-gold);">•</span> <div><strong>Babad Dalem</strong> — Penaklukan Bali oleh Majapahit & Pengangkatan Sri Aji Kresna Kepakisan.</div></li>
                        <li style="margin-bottom: 12px; display: flex; gap: 10px;"><span style="color: var(--accent-gold);">•</span> <div><strong>Babad Arya Tabanan</strong> — Kedatangan Bangsawan Majapahit ke Bali.</div></li>
                        <li style="margin-bottom: 12px; display: flex; gap: 10px;"><span style="color: var(--accent-gold);">•</span> <div><strong>Negarakertagama</strong> — Catatan wilayah kekuasaan Majapahit era Hayam Wuruk.</div></li>
                    </ul>
                    <ul style="list-style: none; padding: 0; color: #666; font-size: 0.95rem; line-height: 1.8;">
                        <li style="margin-bottom: 12px; display: flex; gap: 10px;"><span style="color: var(--accent-gold);">•</span> <div><strong>I Gusti Bagus Sugriwa</strong> — Karya sejarah Bali kuno dan era Majapahit.</div></li>
                        <li style="margin-bottom: 12px; display: flex; gap: 10px;"><span style="color: var(--accent-gold);">•</span> <div><strong>Anak Agung Gde Agung</strong> — <em>Bali pada Abad XIX</em> (Struktur Kerajaan Pasca-Majapahit).</div></li>
                        <li style="margin-bottom: 12px; display: flex; gap: 10px;"><span style="color: var(--accent-gold);">•</span> <div><strong>Repositori Universitas Udayana</strong> — Jurnal sejarah Dinasti Kepakisan & Samprangan.</div></li>
                    </ul>
                </div>
                <div style="margin-top: 40px; padding: 20px; background: var(--section-bg); border-radius: 4px; font-size: 0.85rem; color: #888; font-style: italic;">
                    Catatan: Sejarah Bali abad ke-14 banyak bersumber dari babad dan lontar tradisional, sehingga detail tahun dan silsilah mungkin memiliki variasi antar sumber.
                </div>
            </div>
        </div>
    </section>

    <style>
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateX(-50%) translateY(0);}
            40% {transform: translateX(-50%) translateY(-10px);}
            60% {transform: translateX(-50%) translateY(-5px);}
        }
    </style>
@endsection
