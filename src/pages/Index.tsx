import Layout from "@/components/Layout";
import Icon from "@/components/ui/icon";

export default function AboutPage() {
  return (
    <Layout>
      <div className="animate-fade-in">
        {/* Hero */}
        <div
          className="rounded-2xl p-8 sm:p-12 mb-8 text-white relative overflow-hidden"
          style={{ background: "linear-gradient(135deg, #1E2A3E 0%, #2C3E50 60%, #3B5068 100%)" }}
        >
          <div className="absolute right-0 top-0 w-64 h-64 opacity-5">
            <svg viewBox="0 0 200 200" fill="white">
              <circle cx="100" cy="100" r="80" />
              <circle cx="100" cy="100" r="55" fill="none" stroke="white" strokeWidth="3" />
              <circle cx="100" cy="100" r="30" />
            </svg>
          </div>
          <div className="relative z-10">
            <div className="inline-flex items-center gap-2 bg-white/10 rounded-full px-4 py-1.5 text-sm mb-4">
              <Icon name="Heart" size={14} />
              Общественная организация
            </div>
            <h1 className="text-3xl sm:text-4xl font-extrabold mb-3" style={{ fontFamily: "Montserrat, sans-serif" }}>
              О НАС
            </h1>
            <p className="text-blue-100 text-lg max-w-2xl">
              Ханты-Мансийская региональная организация Всероссийского общества инвалидов
            </p>
          </div>
        </div>

        {/* Main content */}
        <div className="grid lg:grid-cols-3 gap-6">
          <div className="lg:col-span-2 space-y-6">
            <div className="voi-card p-6 stagger-1 animate-fade-in">
              <span className="section-line"></span>
              <h2 className="text-xl font-bold mb-3" style={{ color: "var(--brand-dark)", fontFamily: "Montserrat, sans-serif" }}>
                Кто мы
              </h2>
              <p className="text-gray-600 leading-relaxed mb-4">
                Ханты-Мансийская региональная организация Всероссийского общества инвалидов (ХМАО ВОИ) —
                одна из крупнейших общественных организаций Ханты-Мансийского автономного округа,
                объединяющая людей с ограниченными возможностями здоровья.
              </p>
              <p className="text-gray-600 leading-relaxed">
                Наша организация основана на принципах гуманизма, добровольности и равноправия.
                Мы работаем для того, чтобы каждый человек с инвалидностью имел равные возможности
                в обществе, получал необходимую поддержку и жил полноценной жизнью.
              </p>
            </div>

            <div className="voi-card p-6 stagger-2 animate-fade-in">
              <span className="section-line"></span>
              <h2 className="text-xl font-bold mb-3" style={{ color: "var(--brand-dark)", fontFamily: "Montserrat, sans-serif" }}>
                Наша миссия
              </h2>
              <p className="text-gray-600 leading-relaxed">
                Содействие реализации конституционных прав и законных интересов инвалидов,
                вовлечение их в общественную жизнь, интеграция в общество через реализацию
                социальных, правозащитных, культурных и спортивных проектов.
              </p>
            </div>

            <div className="voi-card p-6 stagger-3 animate-fade-in">
              <span className="section-line"></span>
              <h2 className="text-xl font-bold mb-3" style={{ color: "var(--brand-dark)", fontFamily: "Montserrat, sans-serif" }}>
                Основные направления деятельности
              </h2>
              <ul className="space-y-2 text-gray-600">
                {[
                  "Правовая защита и представительство интересов инвалидов",
                  "Реабилитация и социальная адаптация",
                  "Содействие в трудоустройстве",
                  "Спортивные и культурные мероприятия",
                  "Работа с молодёжью с ограниченными возможностями",
                  "Взаимодействие с государственными органами",
                ].map((item) => (
                  <li key={item} className="flex items-start gap-2">
                    <Icon name="CheckCircle" size={16} className="mt-0.5 flex-shrink-0" style={{ color: "#3B82F6" }} />
                    {item}
                  </li>
                ))}
              </ul>
            </div>
          </div>

          {/* Sidebar */}
          <div className="space-y-4">
            {[
              { icon: "Users", label: "Членов организации", value: "5 000+" },
              { icon: "MapPin", label: "Местных отделений", value: "22" },
              { icon: "Calendar", label: "Год основания", value: "1989" },
              { icon: "Award", label: "Реализованных проектов", value: "150+" },
            ].map((stat, i) => (
              <div key={stat.label} className={`voi-card p-5 text-center stagger-${i + 1} animate-fade-in`}>
                <div
                  className="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3"
                  style={{ background: "var(--brand-light)" }}
                >
                  <Icon name={stat.icon as any} size={22} style={{ color: "var(--brand-dark)" }} />
                </div>
                <div className="text-2xl font-extrabold mb-1" style={{ color: "var(--brand-dark)", fontFamily: "Montserrat, sans-serif" }}>
                  {stat.value}
                </div>
                <div className="text-gray-500 text-sm">{stat.label}</div>
              </div>
            ))}

            <div className="voi-card p-5">
              <h3 className="font-bold mb-3 text-sm uppercase tracking-wide" style={{ color: "var(--brand-dark)", fontFamily: "Montserrat, sans-serif" }}>
                Контакты
              </h3>
              <div className="space-y-2 text-sm text-gray-600">
                <div className="flex items-start gap-2">
                  <Icon name="MapPin" size={14} className="mt-0.5 flex-shrink-0" style={{ color: "#3B82F6" }} />
                  г. Ханты-Мансийск, ул. Примерная, д. 1
                </div>
                <div className="flex items-center gap-2">
                  <Icon name="Phone" size={14} style={{ color: "#3B82F6" }} />
                  8 (3467) 00-00-00
                </div>
                <div className="flex items-center gap-2">
                  <Icon name="Mail" size={14} style={{ color: "#3B82F6" }} />
                  info@hmao-voi.ru
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Layout>
  );
}
