import { useState, useEffect } from "react";
import { Link, useLocation } from "react-router-dom";
import Icon from "@/components/ui/icon";

const NAV_ITEMS = [
  { label: "О НАС", path: "/" },
  { label: "СТРУКТУРА ХМАО ВОИ", path: "/structure" },
  { label: "КОНВЕНЦИЯ ООН", path: "/convention" },
  { label: "ВЕЛИКИЕ ИНВАЛИДЫ", path: "/great-people" },
  { label: "ПРОЕКТЫ", path: "/projects" },
  { label: "НОВОСТИ", path: "/news" },
  { label: "МЕРОПРИЯТИЯ", path: "/events" },
  { label: "ФОТОГРАФИИ", path: "/photos" },
  { label: "ДОКУМЕНТЫ", path: "/documents" },
  { label: "КОМАНДА", path: "/team" },
];

export default function Layout({ children }: { children: React.ReactNode }) {
  const location = useLocation();
  const [impaired, setImpaired] = useState(false);
  const [mobileOpen, setMobileOpen] = useState(false);

  useEffect(() => {
    const saved = localStorage.getItem("visually-impaired") === "true";
    setImpaired(saved);
    document.body.classList.toggle("visually-impaired", saved);
  }, []);

  const toggleImpaired = () => {
    const next = !impaired;
    setImpaired(next);
    localStorage.setItem("visually-impaired", String(next));
    document.body.classList.toggle("visually-impaired", next);
  };

  return (
    <div className="min-h-screen flex flex-col bg-gray-50">
      {/* TOP BAR */}
      <div
        style={{
          background: "linear-gradient(135deg, #0f1c2e 0%, #1a2e48 50%, #1e3a5f 100%)",
          borderBottom: "3px solid #2E9BD6",
        }}
        className="py-3 px-4"
      >
        <div className="max-w-7xl mx-auto flex items-center justify-between gap-4">
          <Link to="/" className="flex items-center gap-4" style={{ textDecoration: "none" }}>
            {/* Логотип на белом фоне-подложке для контраста */}
            <div
              className="flex items-center justify-center rounded-xl flex-shrink-0"
              style={{
                background: "#fff",
                padding: "6px 10px",
                boxShadow: "0 2px 12px rgba(46,155,214,0.25)",
              }}
            >
              <img
                src="https://cdn.poehali.dev/projects/6d8e668c-06d2-482d-8ba9-5c5ab781ac01/bucket/41308084-3816-4a43-8468-c98347110917.png"
                alt="ХМАО ВОИ"
                style={{ height: "44px", width: "auto", objectFit: "contain", display: "block" }}
              />
            </div>
            {/* Текст */}
            <div>
              <div
                className="font-extrabold leading-tight"
                style={{
                  fontFamily: "Montserrat, sans-serif",
                  fontSize: "1rem",
                  color: "#fff",
                  letterSpacing: "0.03em",
                }}
              >
                ХМАО ВОИ
              </div>
              <div style={{ color: "#93C5FD", fontSize: "0.72rem", marginTop: "2px", lineHeight: 1.3 }}>
                Ханты-Мансийская региональная<br className="hidden sm:block" /> организация инвалидов
              </div>
            </div>
          </Link>

          <button
            onClick={toggleImpaired}
            title={impaired ? "Обычная версия" : "Версия для слабовидящих"}
            className="flex items-center gap-2 text-xs px-3 py-1.5 rounded-lg transition"
            style={{
              fontFamily: "Montserrat, sans-serif",
              fontWeight: 600,
              border: impaired ? "1px solid #2E9BD6" : "1px solid rgba(255,255,255,0.3)",
              background: impaired ? "#2E9BD6" : "rgba(255,255,255,0.07)",
              color: "#fff",
            }}
          >
            <Icon name="Eye" size={14} />
            <span className="hidden sm:inline">
              {impaired ? "Обычная версия" : "Версия для слабовидящих"}
            </span>
          </button>
        </div>
      </div>

      {/* NAV BAR */}
      <nav style={{ background: "#1e2d42", boxShadow: "0 2px 10px rgba(0,0,0,0.3)" }} className="sticky top-0 z-50">
        <div className="max-w-7xl mx-auto px-4">
          {/* Desktop */}
          <div className="hidden lg:flex items-center gap-0.5 py-1 flex-wrap">
            {NAV_ITEMS.map((item) => (
              <Link
                key={item.path}
                to={item.path}
                className={`nav-link ${location.pathname === item.path ? "active" : ""}`}
              >
                {item.label}
              </Link>
            ))}
          </div>

          {/* Mobile toggle */}
          <div className="lg:hidden flex items-center justify-between py-2">
            <span className="text-white text-sm font-semibold" style={{ fontFamily: "Montserrat, sans-serif" }}>
              {NAV_ITEMS.find((i) => i.path === location.pathname)?.label ?? "МЕНЮ"}
            </span>
            <button onClick={() => setMobileOpen(!mobileOpen)} className="text-white p-1">
              <Icon name={mobileOpen ? "X" : "Menu"} size={22} />
            </button>
          </div>

          {/* Mobile menu */}
          {mobileOpen && (
            <div className="lg:hidden pb-2 animate-slide-down">
              {NAV_ITEMS.map((item) => (
                <Link
                  key={item.path}
                  to={item.path}
                  onClick={() => setMobileOpen(false)}
                  className={`block nav-link py-2 ${location.pathname === item.path ? "active" : ""}`}
                >
                  {item.label}
                </Link>
              ))}
            </div>
          )}
        </div>
      </nav>

      {/* CONTENT */}
      <main className="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 py-8 animate-fade-in">
        {children}
      </main>

      {/* FOOTER */}
      <footer style={{ background: "linear-gradient(135deg, #0f1c2e 0%, #1a2e48 100%)", borderTop: "3px solid #2E9BD6", color: "#94a3b8" }} className="text-sm py-6 px-4 mt-auto">
        <div className="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between gap-4 items-start">
          <div className="flex items-center gap-3">
            <img
              src="https://cdn.poehali.dev/projects/6d8e668c-06d2-482d-8ba9-5c5ab781ac01/bucket/41308084-3816-4a43-8468-c98347110917.png"
              alt="ХМАО ВОИ"
              className="h-10 w-auto object-contain opacity-90"
            />
            <div>
              <div className="text-white font-semibold mb-0.5" style={{ fontFamily: "Montserrat, sans-serif" }}>
                ХМАО ВОИ
              </div>
              <div>Ханты-Мансийская региональная организация ВОИ</div>
            </div>
          </div>
          <div className="text-right">
            <div>г. Ханты-Мансийск</div>
            <div>© {new Date().getFullYear()} Все права защищены</div>
          </div>
        </div>
      </footer>
    </div>
  );
}