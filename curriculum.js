const curriculum = {
  jazz: {
    label: "Jazz",
    eyebrow: "Private Program",
    description: "Kurikulum jazz bertahap dari groove dasar sampai harmoni dan improvisasi tingkat lanjut.",
    grades: [
      {
        grade: 1,
        title: "Fundamental Jazz",
        summary: "Mengenal swing feel, pentatonic scale, downbeat-backbeat, dan respons improvisasi sederhana.",
        topics: [
          ["Teknik & tangga nada", "C Major dan G Major dua tangan; F Major dan A Minor; C Major Pentatonic; arpeggio G, F, dan A Major/Minor."],
          ["Groove & improvisasi dasar", "Membedakan swing dan straight, merasakan downbeat-backbeat, call and response, serta creative response 4 bar."],
          ["Musical awareness", "Membaca stave, clef, nilai not, rest, dotted notes, serta mendeskripsikan karakter lagu dengan kosakata musik sederhana."]
        ],
        songs: ["Three Chord Trick", "Jangle Rock"]
      },
      {
        grade: 2,
        title: "Fundamental Jazz",
        summary: "Memperkuat scale, Dorian mode, pentatonic, arpeggio, dan groove swing yang lebih stabil.",
        topics: [
          ["Technical work", "D Major dan D Minor dua oktaf, beberapa pentatonic scale dengan swing feel, Dorian mode, serta arpeggio D Major dan G Minor."],
          ["Improvisasi & creative response", "Menggunakan pentatonic dan Dorian untuk variasi melodi spontan, termasuk respons 4 bar setelah stimulus 2 bar."],
          ["Musical awareness", "Dotted notes, aksidental, key/time signature, bar line, rest, dinamika, artikulasi, slur, accent, dan swing phrasing."]
        ],
        songs: ["Ragalong", "Stroller"]
      },
      {
        grade: 3,
        title: "Fundamental Improvisation",
        summary: "Memperluas bahasa improvisasi melalui Blues Scale, Aeolian Mode, embellishment, dan fill yang lebih panjang.",
        topics: [
          ["Technical expansion", "Bb Major, Eb Major, G Minor, C Minor, Aeolian mode, chromatic scale, dan arpeggio dasar."],
          ["Blues & pentatonic language", "D Minor Pentatonic dan D Blues Scale dengan blue note, grace notes, serta slides sebagai embellishment."],
          ["Improvisasi & teori", "Membuat respons 8 bar, mengenali interval sampai Perfect 5th, simbol akord dasar, dan sinkopasi menengah."]
        ],
        songs: ["Morning Waltz", "Four Wheel Drive"]
      },
      {
        grade: 4,
        title: "Jazz Expressions",
        summary: "Mengembangkan ekspresi melalui embellishment, Mixolydian mode, rock groove, dan turnaround.",
        topics: [
          ["Technical mastery", "E, B, Ab Major, B/F Minor, Mixolydian untuk Dominant 7, dan chromatic scale."],
          ["Vocabulary & harmony", "Minor Pentatonic, Blues Scale, arpeggio, broken chord C7/G7 menuju resolusi V-I, serta neighbor tones."],
          ["Improvisasi & sejarah jazz", "Menggabungkan beberapa skala dalam satu alur improvisasi, membuat respons 8 bar, mengenal tokoh/komposer, dan melakukan refleksi."]
        ],
        songs: ["Slash Chord Funk", "Clear Skies"]
      },
      {
        grade: 5,
        title: "Jazz Exploration",
        summary: "Mengeksplorasi Latin, Bossa Nova/Samba, Lydian, modulasi, struktur lagu, dan kadens.",
        topics: [
          ["Advanced technical work", "F Major, F/F# Minor, Dorian, Mixolydian, Aeolian, Lydian, Blues Scale, dan chromatic scale."],
          ["Harmony & dominant resolution", "Arpeggio, Dominant 7th broken chord, resolusi ke tonik, serta menyesuaikan skala saat modulasi."],
          ["Improvisasi & formal structure", "Improvisasi 8 bar dalam swing/Latin atau jazz waltz, repetition, contrast, AABA/ABAC, interval, dan pendekatan Latin."]
        ],
        songs: ["Sweet Blossom Rag", "Latin Carnival"]
      },
      {
        grade: 6,
        title: "Advance Transition",
        summary: "Transisi menuju performa profesional: membaca Real Book, memainkan head, dan mengembangkan dua chorus improvisasi.",
        topics: [
          ["Professional preparation", "Membaca dan menginterpretasikan lead sheet, memainkan head lalu minimal dua chorus improvisasi, serta menjaga stamina."],
          ["Advanced technical work", "Scale tiga oktaf, Blues Scale, jazz modes, dan arpeggio Major, Minor, Augmented, serta Diminished."],
          ["Complex structures & analysis", "Memahami 12-Bar Jazz Blues dengan variasi ii-V-I, extended chords 9/11/13, aransemen lead sheet, dan evaluasi diri."]
        ],
        songs: ["12 Bar Blues (Own Composition Based on the Blues)", "Frog", "C Jam Blues"]
      },
      {
        grade: 7,
        title: "Harmony Expertise",
        summary: "Menguasai ii-V-I, block chords, Circle of Fifths, mode lanjutan, dan improvisasi artistik.",
        topics: [
          ["Advanced scales & modes", "F#, Db, Eb Major, minor scales, Mixolydian, Phrygian, Blues Scale, dan chromatic vocabulary."],
          ["Specialized harmony", "Block chords/locked-hands, ii-V-I di beberapa kunci, voice leading, serta Circle of Fifths untuk transposisi."],
          ["Improvisasi & konteks sejarah", "Tension-release ii-V-I, creative response dalam jazz waltz/swing, fungsi akord, dan konteks Bebop/Bossa Nova."]
        ],
        songs: ["Honeysuckle Rose", "Reflections", "Own Composition Based on ii-V-I Sequences", "King Porter Stomp"]
      },
      {
        grade: 8,
        title: "Jazz Advance",
        summary: "Mencapai kematangan artistik melalui substitusi kompleks, Whole Tone, Diminished Scale, dan analisis skor jazz.",
        topics: [
          ["Modern scales", "Similar Motion tiga oktaf, Whole Tone Scale, Diminished Scale, dan chromatic movement dalam minor third."],
          ["Advanced harmony & voicing", "Sus chord dan resolusinya, Tritone Substitution, chromatic bassline, turnaround iii-vi-ii-V, dominant chain, dan tritone turnaround."],
          ["Improvisasi & critical discussion", "Creative response 8 bar, narasi improvisasi personal, ruang dan kontras dinamika, motif development, serta analisis voicing dan struktur."]
        ],
        songs: ["Autumn Leaves", "Cat & Mouse", "A Taste of Honey", "Own Composition Based on Rhythm Changes"]
      }
    ]
  },
  worship: {
    label: "Worship",
    eyebrow: "Private Program",
    description: "Kurikulum worship dari dasar keyboard dan chord sampai worship flow serta kepemimpinan musikal.",
    grades: [
      {
        grade: 0,
        title: "Fondasi Awal",
        summary: "Grade 0 dibagi menjadi 0A dan 0B: mengenal keyboard, chord dasar, ritme 4/4, dan koordinasi dua tangan.",
        topics: [
          ["Grade 0A — fondasi", "Navigasi nada C/F, C Major satu oktaf, broken triad dan arpeggio, block chord C/F/G, power chord 1-5, pola worship 4/4, dan not angka dasar."],
          ["Grade 0B — pengembangan", "F Major dan G Major, broken triad/arpeggio, warna mayor-minor, progresi I-IV-V, serta koordinasi LH/RH."],
          ["Aural & literasi", "Membedakan karakter chord mayor dan minor, serta membaca treble clef dari Middle C sampai G."]
        ],
        songs: ["Kingkong Badannya Besar", "Setinggi-tingginya Langit", "Hati-Hati Gunakan Tanganmu", "Dengar Dia Panggil Nama Saya", "Aku Anak Raja", "Jalan Serta Yesus", "Dari Terbit Matahari", "Bapa Abraham", "T’rimakasih Yesusku", "Yesus Besertaku", "Laskar Kristus", "Happy Ya Ya Ya"]
      },
      {
        grade: 1,
        title: "Worship Foundation",
        summary: "Menguatkan memori otot, pola bass kiri, inversi, sustain pedal, voice leading, dinamika, dan fill sederhana.",
        topics: [
          ["Teknik jari & koordinasi", "LH Expansion 1-5-1' sampai pola yang lebih panjang, inversi root/1st/2nd, dan sustain pedal legato."],
          ["Teori harmoni", "Roman numeral I–vi, kualitas mayor/minor, dan progresi I-V-vi-IV pada F Major dan G Major."],
          ["Fill-in & navigasi lagu", "Broken triad fill-in, simple lick transisi, dynamic touch, not angka, treble clef dua oktaf, dan struktur intro-verse-chorus-ending."]
        ],
        songs: ["K.A.S.I.H", "Selamat Pagi Bapa", "Mari kita bersukaria", "Yesus Kekasih Jiwaku", "Yesus Pokok", "Burung Pipit yang Kecil", "Hari ini Kurasa Bahagia", "Lima Roti dan Dua Ikan", "Kasihnya Seperti Sungai", "Dalam Yesus Kita Bersaudara", "Mata Tuhan Melihat", "Yesus Sayang Padaku"]
      },
      {
        grade: 2,
        title: "Modern Chord Colors",
        summary: "Mengenal suspended/add9, kunci baru, Waltz, Stride/Ragtime, Hymn Style, dan extended arpeggio.",
        topics: [
          ["Harmoni & warna chord", "Sus2/sus4, resolusi tension-release, add9/add2, serta progresi D Major dan Bb Major."],
          ["Pattern & agilitas", "Waltz 3/4, Stride/Ragtime, Hymn Style, dan Extended Upward Arpeggio/The Rain Effect."],
          ["Strategi & fill-in", "Membedakan voicing dan progresi, menyesuaikan permainan solo/band, scale-run fill-in, dan pentatonic lick 1-2-3-5-6."]
        ],
        songs: ["Kasih Yesus Indah-indah oh indah", "Hati yang Gembira adalah Obat", "Baca Kitab Suci Doa Tiap Hari", "Sentuh Hatiku", "Betapa Hatiku", "Tiap Langkahku", "Seperti yang Kau Ingini", "Dia mengerti Dia Peduli", "Bapa Surgawi", "Bapa Engkau Sungguh Baik", "Seperti Rusa Rindu", "Indah Rencamu Tuhan"]
      },
      {
        grade: 3,
        title: "Inversion & Melodic Bass",
        summary: "Menguasai inversi secara refleks, slash chord, fill interval, intro/outro, dan ending yang musikal.",
        topics: [
          ["Penguasaan inversion", "Root, 1st, dan 2nd inversion pada C, G, F, D, dan Bb Major dengan perpindahan halus."],
          ["Harmoni & melodic fill", "Slash chord untuk bass berjalan, non-inversion slash chord, interval 3rd/6th, dan syncopated fill-in."],
          ["Navigasi & leadership", "Membuat intro/outro, praise upbeat pattern, octave jumping LH, backbeat RH, ritardando, dan fade-out."]
        ],
        songs: ["Janjimu Seperti Fajar", "Pelangi Kasihnya", "Kumilik-Mu", "Bagi Tuhan Tak ada yang Mustahil", "Tak Terbatas", "Sejauh Timur dari Barat", "Sbab Dia Hidup", "Allah Bangkit", "Hari Terbaik", "Api Kemuliaannya", "Sgala Puji Syukur", "Ajaib Kau Tuhan"]
      },
      {
        grade: 4,
        title: "Inner Voice & Direction",
        summary: "Mengembangkan inner voice, finger weight balance, 7th chord, passing chord, modulasi, dan play by ear.",
        topics: [
          ["Inner voice & finger balance", "Melodic comping, top note sebagai melodi, dan keseimbangan tekanan jari."],
          ["7th family & chord bridge", "Major 7, Dominant 7, passing diminished/augmented, serta resolusi menuju akord tujuan."],
          ["Pattern, modulasi & direction", "Flowing worship pattern, direct modulation, piano cues, build-up/stop cue, hand signal, dan solfege-to-harmony."]
        ],
        songs: ["Mukjizat Itu Nyata", "Tenang", "Tertawa", "Tetap Setia", "BejanaMu", "Hossana", "Terlalu Besar", "Tuhan Pasti Sanggup", "Kau Terbesar dan Mulia", "Pilihanku", "Sejuta Rasa", "Goodness of God"]
      },
      {
        grade: 5,
        title: "Advanced Worship Flow",
        summary: "Mendalami Secondary Dominant, ii-V-I, chromatic bassline, Latin/Bossa, birama majemuk, modulasi, dan atmosfer doa.",
        topics: [
          ["Advanced harmonic movement", "Secondary Dominant, ii-V-I, dan chromatic bassline untuk transisi yang lebih kuat dan halus."],
          ["Genre & rhythm exploration", "Latin/Montuno, Bossa Nova/Samba, hand independence, serta birama 6/8, 9/8, dan 12/8."],
          ["Worship flow & atmosphere", "Pedal tones, open voicing, spontaneous prayer atmosphere, dan modulasi artistik ke kunci yang lebih jauh."]
        ],
        songs: ["Dengan Apa Kan Kubalas", "Kuasamu Terlebih Besar", "Mengikut Yesus", "Mujizat Dalam Bersyukur", "Hidup Adalah Kesempatan", "Yesus Kau Sungguh Baik", "Kunyanyi Haleluya", "Penolong Yang Setia", "Lingkupiku", "Berkat Kemurahanmu", "How Great Thou Art", "Sampai Akhir Hidupku"]
      },
      {
        grade: 6,
        title: "Groove & Motif Development",
        summary: "Memperluas Swing, Blues, Boogie Woogie, passing notes, extension fill-in, line cliché, dan intro improvisatif.",
        topics: [
          ["Genre & groove", "Swing feel, blue notes, triplet feel, dan Boogie Woogie walking bass yang stabil."],
          ["Melodic & harmonic embellishment", "Passing notes, extension fill-in dengan 9th/11th/13th, serta major/minor line cliché."],
          ["Improvisasi & composer mindset", "Membuat intro tematik, mengembangkan motif melalui ritme/sequencing/register, dan membangun response phrase."]
        ],
        songs: ["Tuhan Kupercaya", "Tak Terbatas", "Penyertaan Tuhan", "Kupercaya JanjiMu", "Gloria", "Jadi SepertiMu", "Bapa Kau Setia", "Jesus Jalan Kebenaran", "Harapanku", "Anggur Baru", "Dia Sungguh Baik", "S'bab Tuhan Baik (Masuk GerbangNya Bersyukur)"]
      },
      {
        grade: 7,
        title: "Modern Harmony & Texture",
        summary: "Menguasai Quartal Voicing, Tritone Substitution, pedal tone, ekstensi chord, pentatonic manipulation, dan polyrhythm.",
        topics: [
          ["Modern harmony", "Quartal voicing, Tritone Substitution, inner/top pedal tones, dan tekstur suara yang luas."],
          ["Extensions & substitutions", "Chord 9th/11th/13th, advanced chord substitution, dan line cliché untuk melodi tersembunyi."],
          ["Virtuosity & rhythm", "Manipulasi pentatonic dengan lompatan interval serta koordinasi polyrhythm 3 lawan 4."]
        ],
        songs: ["Sungguh Indah", "Bagai Rajawali", "Tak 'Ku Tahu 'Kan Hari Esok", "Biar Bumi Akan Berlalu", "Waktu Tuhan", "Datanglah dan Bertahta", "Karya Terbesar", "MengenalMu", "Terhubung", "Lebih Dari Pemenang", "Kau 1, 2, 3", "Kasih Allah Tak Berkesudahan"]
      },
      {
        grade: 8,
        title: "Extreme Harmony & Music Direction",
        summary: "Menguasai altered chord, polychord, upper structure, transposisi 12 kunci, dan memimpin worship flow sebagai Music Director.",
        topics: [
          ["Extreme harmony", "Altered Dominant 7(b9), 7(#9), 7(#11), 7(b13), polychord, dan Upper Structure Triad."],
          ["Ear training & transposition", "Play by ear tingkat lanjut, menangkap progresi/bassline/voicing, dan memindahkan materi ke 12 kunci."],
          ["Leadership & 15-minute flow", "Mengatur worship licks, membangun atmosfer doa 10–15 menit, mengelola klimaks, ritardando, decrescendo, dan hening."]
        ],
        songs: ["Sebab Tuhan Maha Besar", "Kunaikkan Syukurku", "O Holy Night", "Langit Dan Bumi Pujilah Tuhan", "Sukacita Surga", "Above All", "Tak Tertandingi", "Kaulah Kuatku", "Dia Raja", "Tuhan Selalu Menolongku", "S’lalu Bersamaku", "Karena SalibMu"]
      }
    ]
  }
};



// Questions, pilihan jawaban, kunci, dan skor untuk setiap topik.
function buildTopicQuestions(trackLabel, gradeNumber, topic) {
  const title = topic[0];
  const detail = topic[1];
  return [
    "Apa tujuan utama topik \"" + title + "\" pada " + trackLabel + " Grade " + gradeNumber + "?",
    "Sebutkan minimal dua konsep atau teknik yang termasuk dalam topik \"" + title + "\".",
    "Jelaskan dengan kata-katamu sendiri materi berikut: " + detail,
    "Bagaimana cara melatih topik \"" + title + "\" secara bertahap di piano?",
    "Apa yang harus didengarkan atau diperhatikan agar penerapan \"" + title + "\" terdengar/terasa benar?",
    "Buat satu contoh latihan singkat yang menerapkan topik \"" + title + "\".",
    "Bagaimana cara mengevaluasi bahwa kamu sudah menguasai topik \"" + title + "\"?"
  ];
}

function buildQuizQuestions(trackLabel, gradeNumber, topic, topicIndex) {
  const title = topic[0];
  const detail = topic[1];
  const prompts = topic[2];
  const questionData = [
    { question: prompts[0], correct: "Fokus utama yang dipelajari adalah " + title + ".", wrong: ["Menghafal semua judul lagu tanpa memahami materinya.", "Mengganti seluruh materi dengan teori yang tidak terkait.", "Mengabaikan teknik dan hanya mengejar tempo."], explanation: "Topik ini berpusat pada " + title + "." },
    { question: prompts[1], correct: "Konsep yang tercantum dalam ringkasan materi " + title + ".", wrong: ["Hanya nama alat musik dan jadwal latihan.", "Daftar lagu tanpa teknik atau konsep musik.", "Materi yang tidak berhubungan dengan grade ini."], explanation: "Gunakan ringkasan topik sebagai acuan untuk mengenali konsep dan tekniknya." },
    { question: prompts[2], correct: detail, wrong: ["Materi cukup dibaca tanpa pernah dipraktikkan.", "Semua lagu harus dimainkan secepat mungkin.", "Teknik tidak perlu disesuaikan dengan jalur belajar."], explanation: detail },
    { question: prompts[3], correct: "Mulai dari konsep dasar, latihan perlahan, gabungkan kedua tangan, lalu naikkan tempo secara bertahap.", wrong: ["Langsung memainkan materi pada tempo tercepat.", "Berlatih hanya saat sudah tampil di depan orang lain.", "Menghafal tanpa mendengarkan hasil permainan."], explanation: "Latihan bertahap membantu kontrol teknik, koordinasi, dan musikalitas berkembang bersama." },
    { question: prompts[4], correct: "Dengarkan feel, ketepatan ritme, warna harmoni, dinamika, dan kontrol permainan sesuai materi.", wrong: ["Hanya menghitung jumlah nada tanpa mendengar bunyinya.", "Memainkan semua bagian dengan volume dan artikulasi yang sama.", "Mengabaikan groove selama not yang dimainkan benar."], explanation: "Penguasaan musik perlu dinilai dari bunyi dan rasa, bukan hanya dari catatan tertulis." },
    { question: prompts[5], correct: "Latihan singkat yang menggabungkan inti materi " + title + " pada pola atau lagu yang sederhana.", wrong: ["Latihan yang tidak memakai satu pun unsur dari topik.", "Memainkan lagu acak tanpa target teknik.", "Mengubah semua materi menjadi latihan kecepatan."], explanation: "Contoh latihan harus tetap mengandung unsur utama " + title + "." },
    { question: prompts[6], correct: "Jelaskan konsepnya, terapkan dengan kontrol, lalu cocokkan hasil bunyi dengan target grade.", wrong: ["Mengukur penguasaan hanya dari hafalan judul topik.", "Mengabaikan kesalahan selama lagu selesai dimainkan.", "Menilai diri hanya dari seberapa cepat tempo dimainkan."], explanation: "Evaluasi yang baik menggabungkan pemahaman, teknik, bunyi, dan penerapan musikal." }
  ];
  return questionData.map((item, questionIndex) => {
    const options = [item.correct, ...item.wrong];
    const rotation = (gradeNumber + topicIndex + questionIndex) % options.length;
    const orderedOptions = options.slice(rotation).concat(options.slice(0, rotation));
    return { question: item.question, options: orderedOptions, answer: orderedOptions.indexOf(item.correct), explanation: item.explanation };
  });
}

Object.entries(curriculum).forEach(([trackKey, track]) => {
  track.grades.forEach(grade => {
    grade.topics.forEach((topic, topicIndex) => {
      topic[2] = buildTopicQuestions(track.label, grade.grade, topic);
      topic[3] = buildQuizQuestions(track.label, grade.grade, topic, topicIndex);
    });
  });
});
