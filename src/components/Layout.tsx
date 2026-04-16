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
      <div style={{ background: "var(--brand-dark)" }} className="py-2 px-4">
        <div className="max-w-7xl mx-auto flex items-center justify-between">
          <div className="flex items-center gap-3">
            <Link to="/" className="flex items-center gap-3" style={{ textDecoration: "none" }}>
              <img
                src="https://cdn.poehali.dev/projects/6d8e668c-06d2-482d-8ba9-5c5ab781ac01/bucket/41308084-3816-4a43-8468-c98347110917.png"
                alt="ХМАО ВОИ"
                className="h-12 w-auto object-contain"
                style={{ filter: "drop-shadow(0 1px 3px rgba(0,0,0,0.25))" }}
              />
              <div>
                <div className="text-white font-bold text-sm leading-tight" style={{ fontFamily: "Montserrat, sans-serif" }}>
                  ХМАО ВОИ
                </div>
                <div className="text-blue-200 text-xs leading-tight">Ханты-Мансийская региональная организация</div>
              </div>
            </Link>
          </div>

          <button
            onClick={toggleImpaired}
            title={impaired ? "Обычная версия" : "Версия для слабовидящих"}
            className="flex items-center gap-2 text-white text-xs px-3 py-1.5 rounded border border-white/30 hover:bg-white/10 transition"
            style={{ fontFamily: "Montserrat, sans-serif" }}
          >
            <Icon name="Eye" size={15} />
            <span className="hidden sm:inline">
              {impaired ? "Обычная версия" : "Версия для слабовидящих"}
            </span>
          </button>
        </div>
      </div>

      {/* NAV BAR */}
      <nav style={{ background: "var(--brand-mid)" }} className="shadow-md sticky top-0 z-50">
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
      <footer style={{ background: "var(--brand-dark)", color: "#94a3b8" }} className="text-sm py-6 px-4 mt-auto">
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