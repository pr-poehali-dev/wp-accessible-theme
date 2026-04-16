import { useState } from "react";
import Layout from "@/components/Layout";
import Icon from "@/components/ui/icon";

const ALBUMS = [
  {
    id: 1,
    title: "Паралимпийский чемпионат 2025",
    date: "Ноябрь 2025",
    count: 8,
    cover: "🏊",
    photos: ["🏊","🏋️","🎯","⛷️","🚴","🏓","♟️","🤸"],
  },
  {
    id: 2,
    title: "Фестиваль «Нет границ для таланта»",
    date: "Июнь 2025",
    count: 6,
    cover: "🎨",
    photos: ["🎨","🎭","🎵","🎶","🖼️","🎪"],
  },
  {
    id: 3,
    title: "День открытых дверей 2025",
    date: "Май 2025",
    count: 5,
    cover: "🤝",
    photos: ["🤝","👥","📋","🗣️","🏛"],
  },
  {
    id: 4,
    title: "Выставка «Мастерская талантов»",
    date: "Март 2025",
    count: 7,
    cover: "🖼️",
    photos: ["🖼️","🧶","🪆","🧸","🎀","💎","🌸"],
  },
];

const PHOTOS_FLAT = [
  { src: "https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=400&h=300&fit=crop", alt: "Мероприятие 1" },
  { src: "https://images.unsplash.com/photo-1517649763962-0c623066013b?w=400&h=300&fit=crop", alt: "Спорт" },
  { src: "https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=400&h=300&fit=crop", alt: "Встреча" },
  { src: "https://images.unsplash.com/photo-1511632765486-a01980e01a18?w=400&h=300&fit=crop", alt: "Команда" },
  { src: "https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=400&h=300&fit=crop", alt: "Семинар" },
  { src: "https://images.unsplash.com/photo-1543269865-cbf427effbad?w=400&h=300&fit=crop", alt: "Праздник" },
  { src: "https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=400&h=300&fit=crop", alt: "Форум" },
  { src: "https://images.unsplash.com/photo-1491438590914-bc09fcaaf77a?w=400&h=300&fit=crop", alt: "Концерт" },
  { src: "https://images.unsplash.com/photo-1528605248644-14dd04022da1?w=400&h=300&fit=crop", alt: "Выставка" },
];

export default function PhotosPage() {
  const [activeAlbum, setActiveAlbum] = useState<number | null>(null);
  const [lightbox, setLightbox] = useState<number | null>(null);

  return (
    <Layout>
      <div className="animate-fade-in">
        <div
          className="rounded-2xl p-8 sm:p-10 mb-8 text-white"
          style={{ background: "linear-gradient(135deg, #1E2A3E 0%, #2C3E50 100%)" }}
        >
          <div className="inline-flex items-center gap-2 bg-white/10 rounded-full px-4 py-1.5 text-sm mb-4">
            <Icon name="Image" size={14} />
            Фотоархив
          </div>
          <h1 className="text-3xl sm:text-4xl font-extrabold mb-2" style={{ fontFamily: "Montserrat, sans-serif" }}>
            ФОТОГРАФИИ
          </h1>
          <p className="text-blue-100">Фотоальбомы мероприятий и событий</p>
        </div>

        {/* Albums */}
        <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
          {ALBUMS.map((album, i) => (
            <button
              key={album.id}
              onClick={() => setActiveAlbum(activeAlbum === album.id ? null : album.id)}
              className={`voi-card p-4 text-left stagger-${i + 1} animate-fade-in transition-all ${
                activeAlbum === album.id ? "ring-2 ring-blue-500" : ""
              }`}
            >
              <div
                className="w-full h-24 rounded-lg flex items-center justify-center text-5xl mb-3"
                style={{ background: "var(--brand-light)" }}
              >
                {album.cover}
              </div>
              <h3 className="font-bold text-sm mb-1" style={{ color: "var(--brand-dark)", fontFamily: "Montserrat, sans-serif" }}>
                {album.title}
              </h3>
              <div className="flex items-center justify-between text-xs text-gray-400">
                <span>{album.date}</span>
                <span className="flex items-center gap-1">
                  <Icon name="Images" size={11} />
                  {album.count}
                </span>
              </div>
            </button>
          ))}
        </div>

        {/* Photo grid */}
        <h2 className="text-xl font-bold mb-4" style={{ color: "var(--brand-dark)", fontFamily: "Montserrat, sans-serif" }}>
          Все фотографии
        </h2>
        <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
          {PHOTOS_FLAT.map((photo, i) => (
            <button
              key={i}
              onClick={() => setLightbox(i)}
              className={`relative group overflow-hidden rounded-xl stagger-${(i % 6) + 1} animate-fade-in`}
              style={{ aspectRatio: "4/3" }}
            >
              <img
                src={photo.src}
                alt={photo.alt}
                className="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
              />
              <div className="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition flex items-center justify-center">
                <Icon name="ZoomIn" size={24} className="text-white opacity-0 group-hover:opacity-100 transition" />
              </div>
            </button>
          ))}
        </div>

        {/* Lightbox */}
        {lightbox !== null && (
          <div
            className="fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4"
            onClick={() => setLightbox(null)}
          >
            <button
              className="absolute top-4 right-4 text-white p-2 hover:bg-white/10 rounded-lg"
              onClick={() => setLightbox(null)}
            >
              <Icon name="X" size={24} />
            </button>
            <img
              src={PHOTOS_FLAT[lightbox].src.replace("w=400&h=300", "w=1200&h=800")}
              alt={PHOTOS_FLAT[lightbox].alt}
              className="max-w-full max-h-full rounded-xl object-contain"
              onClick={(e) => e.stopPropagation()}
            />
          </div>
        )}
      </div>
    </Layout>
  );
}
