import Layout from "@/components/Layout";
import Icon from "@/components/ui/icon";

const EVENTS = [
  {
    id: 1,
    date: "25 апреля 2026",
    time: "10:00",
    title: "Отчётно-выборная конференция ХМАО ВОИ",
    place: "г. Ханты-Мансийск, ул. Мира, 5 — Дом народного творчества",
    type: "Конференция",
    description: "Ежегодная отчётно-выборная конференция региональной организации. Подведение итогов работы, избрание руководящих органов на новый срок.",
  },
  {
    id: 2,
    date: "3 мая 2026",
    time: "11:00",
    title: "День открытых дверей в местных отделениях",
    place: "Во всех городах и районах округа",
    type: "Открытое мероприятие",
    description: "Жители ХМАО смогут познакомиться с деятельностью местных отделений ВОИ, получить консультации, узнать о программах и вступить в организацию.",
  },
  {
    id: 3,
    date: "15 мая 2026",
    time: "09:00",
    title: "Региональный чемпионат по настольному теннису среди инвалидов",
    place: "г. Сургут, спорткомплекс «Олимпия»",
    type: "Спортивное",
    description: "Ежегодный чемпионат по адаптивному настольному теннису. Принимают участие спортсмены из всех местных отделений ХМАО ВОИ.",
  },
  {
    id: 4,
    date: "20 мая 2026",
    time: "14:00",
    title: "Семинар: «Социальные права инвалидов в 2026 году»",
    place: "г. Ханты-Мансийск, пр. Ленина, 3 — Конференц-зал",
    type: "Семинар",
    description: "Практический семинар с участием юристов и социальных работников. Темы: новые льготы, изменения в законодательстве, порядок получения ТСР.",
  },
  {
    id: 5,
    date: "1 июня 2026",
    time: "12:00",
    title: "Праздник «Вместе мы сильнее» в День защиты детей",
    place: "г. Нижневартовск, парк «Дружба»",
    type: "Праздник",
    description: "Праздничное мероприятие для детей с инвалидностью и их семей. Конкурсы, мастер-классы, концерт, угощения. Вход свободный.",
  },
  {
    id: 6,
    date: "10 июня 2026",
    time: "10:00",
    title: "Творческий фестиваль «Нет границ для таланта»",
    place: "г. Ханты-Мансийск, Культурный центр «Лангал»",
    type: "Культурное",
    description: "Региональный фестиваль творчества людей с инвалидностью. Выступления вокалистов, художественные экспозиции, театральные постановки.",
  },
];

const TYPE_ICONS: Record<string, string> = {
  "Конференция":        "Users",
  "Открытое мероприятие": "DoorOpen",
  "Спортивное":         "Trophy",
  "Семинар":            "BookOpen",
  "Праздник":           "PartyPopper",
  "Культурное":         "Music",
};

export default function EventsPage() {
  return (
    <Layout>
      <div className="animate-fade-in">
        <div
          className="rounded-2xl p-8 sm:p-10 mb-8 text-white"
          style={{ background: "linear-gradient(135deg, #1E2A3E 0%, #2C3E50 100%)" }}
        >
          <div className="inline-flex items-center gap-2 bg-white/10 rounded-full px-4 py-1.5 text-sm mb-4">
            <Icon name="Calendar" size={14} />
            Предстоящие события
          </div>
          <h1 className="text-3xl sm:text-4xl font-extrabold mb-2" style={{ fontFamily: "Montserrat, sans-serif" }}>
            МЕРОПРИЯТИЯ
          </h1>
          <p className="text-blue-100">Афиша событий ХМАО ВОИ</p>
        </div>

        <div className="space-y-4">
          {EVENTS.map((ev, i) => (
            <div key={ev.id} className={`voi-card p-5 flex gap-5 stagger-${(i % 6) + 1} animate-fade-in`}>
              {/* Date block */}
              <div
                className="flex-shrink-0 w-16 rounded-xl text-center py-3 text-white"
                style={{ background: "var(--brand-dark)" }}
              >
                <div className="text-xl font-extrabold leading-none" style={{ fontFamily: "Montserrat, sans-serif" }}>
                  {ev.date.split(" ")[0]}
                </div>
                <div className="text-xs mt-1 text-blue-200">{ev.date.split(" ")[1]}</div>
              </div>

              <div className="flex-1 min-w-0">
                <div className="flex flex-wrap items-center gap-2 mb-2">
                  <div className="flex items-center gap-1.5">
                    <Icon name={TYPE_ICONS[ev.type] as "Users"} size={13} style={{ color: "#3B82F6" }} />
                    <span className="text-xs text-gray-400">{ev.type}</span>
                  </div>
                  <span className="flex items-center gap-1 text-xs text-gray-400">
                    <Icon name="Clock" size={12} />
                    {ev.time}
                  </span>
                </div>
                <h3 className="font-bold mb-1.5" style={{ color: "var(--brand-dark)", fontFamily: "Montserrat, sans-serif" }}>
                  {ev.title}
                </h3>
                <div className="flex items-start gap-1.5 text-sm text-gray-500 mb-2">
                  <Icon name="MapPin" size={13} className="mt-0.5 flex-shrink-0" style={{ color: "#3B82F6" }} />
                  {ev.place}
                </div>
                <p className="text-gray-600 text-sm leading-relaxed">{ev.description}</p>
              </div>
            </div>
          ))}
        </div>
      </div>
    </Layout>
  );
}
