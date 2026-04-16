import Layout from "@/components/Layout";
import Icon from "@/components/ui/icon";

const NEWS = [
  {
    id: 1,
    date: "12 апреля 2026",
    title: "ХМАО ВОИ приняла участие в межрегиональном форуме по инклюзии",
    category: "Мероприятия",
    text: "Представители нашей организации выступили с докладом о лучших практиках социальной интеграции людей с инвалидностью на межрегиональном форуме «Равные возможности», прошедшем в Екатеринбурге.",
  },
  {
    id: 2,
    date: "5 апреля 2026",
    title: "Открытие новой спортивной секции адаптивного плавания в Сургуте",
    category: "Спорт",
    text: "В Сургуте при поддержке городской администрации и ХМАО ВОИ открылась секция адаптивного плавания для детей и взрослых с нарушениями опорно-двигательного аппарата. Занятия проводятся три раза в неделю.",
  },
  {
    id: 3,
    date: "28 марта 2026",
    title: "Выставка работ участников проекта «Мастерская талантов» открылась в Ханты-Мансийске",
    category: "Культура",
    text: "В городском выставочном зале открылась экспозиция изделий ручной работы, созданных участниками нашего проекта. На выставке представлено более 120 работ — картины, керамика, текстиль и украшения.",
  },
  {
    id: 4,
    date: "15 марта 2026",
    title: "Итоги программы «Путь к работе»: 47 человек трудоустроены",
    category: "Занятость",
    text: "Программа содействия трудоустройству людей с инвалидностью завершила работу за 2025 год. По её итогам 47 участников нашли постоянную работу у партнёров-работодателей в Ханты-Мансийске, Сургуте и Нижневартовске.",
  },
  {
    id: 5,
    date: "2 марта 2026",
    title: "Семинар по получению средств реабилитации прошёл в нескольких городах округа",
    category: "Правовая помощь",
    text: "Специалисты ХМАО ВОИ провели серию выездных семинаров по вопросам получения технических средств реабилитации. Более 300 человек получили консультации по оформлению документов.",
  },
  {
    id: 6,
    date: "18 февраля 2026",
    title: "Региональная паралимпийская эстафета: ХМАО ВОИ в числе победителей",
    category: "Спорт",
    text: "Команда ХМАО ВОИ заняла второе место в региональной паралимпийской эстафете среди организаций инвалидов Уральского федерального округа. Поздравляем наших спортсменов!",
  },
];

const CAT_COLORS: Record<string, string> = {
  "Мероприятия":    "#DBEAFE",
  "Спорт":          "#D1FAE5",
  "Культура":       "#FEF3C7",
  "Занятость":      "#E0E7FF",
  "Правовая помощь":"#FCE7F3",
};

export default function NewsPage() {
  return (
    <Layout>
      <div className="animate-fade-in">
        <div
          className="rounded-2xl p-8 sm:p-10 mb-8 text-white"
          style={{ background: "linear-gradient(135deg, #1E2A3E 0%, #2C3E50 100%)" }}
        >
          <div className="inline-flex items-center gap-2 bg-white/10 rounded-full px-4 py-1.5 text-sm mb-4">
            <Icon name="Newspaper" size={14} />
            Актуальные события
          </div>
          <h1 className="text-3xl sm:text-4xl font-extrabold mb-2" style={{ fontFamily: "Montserrat, sans-serif" }}>
            НОВОСТИ
          </h1>
          <p className="text-blue-100">Последние новости организации</p>
        </div>

        <div className="space-y-5">
          {NEWS.map((item, i) => (
            <div key={item.id} className={`voi-card p-6 stagger-${(i % 6) + 1} animate-fade-in`}>
              <div className="flex flex-wrap items-center gap-3 mb-3">
                <span
                  className="text-xs font-semibold px-2.5 py-1 rounded-full"
                  style={{
                    background: CAT_COLORS[item.category] ?? "#F3F4F6",
                    color: "var(--brand-dark)",
                  }}
                >
                  {item.category}
                </span>
                <span className="flex items-center gap-1 text-xs text-gray-400">
                  <Icon name="Calendar" size={12} />
                  {item.date}
                </span>
              </div>
              <h3
                className="font-bold text-lg mb-2 leading-snug"
                style={{ color: "var(--brand-dark)", fontFamily: "Montserrat, sans-serif" }}
              >
                {item.title}
              </h3>
              <p className="text-gray-600 text-sm leading-relaxed">{item.text}</p>
              <button
                className="mt-4 text-sm font-semibold flex items-center gap-1 hover:gap-2 transition-all"
                style={{ color: "var(--brand-mid)" }}
              >
                Читать далее <Icon name="ArrowRight" size={14} />
              </button>
            </div>
          ))}
        </div>
      </div>
    </Layout>
  );
}
