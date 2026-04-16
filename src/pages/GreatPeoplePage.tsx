import Layout from "@/components/Layout";
import Icon from "@/components/ui/icon";

const PEOPLE = [
  {
    name: "Людвиг ван Бетховен",
    years: "1770–1827",
    field: "Музыкант, композитор",
    description: "Один из величайших композиторов всех времён. Несмотря на полную глухоту, написал свои лучшие произведения, в том числе знаменитую Девятую симфонию.",
    emoji: "🎵",
  },
  {
    name: "Стивен Хокинг",
    years: "1942–2018",
    field: "Физик-теоретик",
    description: "Выдающийся учёный, автор теорий о чёрных дырах и космологии. Болел боковым амиотрофическим склерозом с 21 года, полностью потеряв подвижность, но продолжал работать до конца жизни.",
    emoji: "🔭",
  },
  {
    name: "Фрида Кало",
    years: "1907–1954",
    field: "Художница",
    description: "Мексиканская художница, ставшая символом стойкости духа. После тяжёлой автомобильной аварии перенесла более 30 операций и создала более 140 картин.",
    emoji: "🎨",
  },
  {
    name: "Франклин Рузвельт",
    years: "1882–1945",
    field: "Политик, 32-й президент США",
    description: "Единственный президент США, переизбиравшийся четыре раза. Перенёс полиомиелит в 1921 году и большую часть жизни провёл в инвалидной коляске, но руководил страной в годы Великой депрессии и Второй мировой войны.",
    emoji: "🏛",
  },
  {
    name: "Рэй Чарльз",
    years: "1930–2004",
    field: "Музыкант, певец",
    description: "Легенда американской музыки, потерявший зрение в возрасте 7 лет. Пионер соул-музыки, объединивший ритм-н-блюз, джаз и госпел.",
    emoji: "🎹",
  },
  {
    name: "Хелен Келлер",
    years: "1880–1968",
    field: "Писательница, общественный деятель",
    description: "Первый слепоглухой человек, получивший высшее образование. Автор 12 книг, борец за права инвалидов и женщин по всему миру.",
    emoji: "📚",
  },
  {
    name: "Ник Вуйчич",
    years: "1982",
    field: "Мотивационный оратор",
    description: "Рождённый без рук и ног, стал известным мотивационным оратором, выступавшим перед более чем 400 миллионами людей в 57 странах мира.",
    emoji: "💪",
  },
  {
    name: "Алексей Маресьев",
    years: "1916–2001",
    field: "Лётчик-ас, Герой СССР",
    description: "Советский военный лётчик, после ампутации обеих ног вернулся в строй и совершил ещё 86 боевых вылетов. Прообраз главного героя «Повести о настоящем человеке».",
    emoji: "✈️",
  },
];

export default function GreatPeoplePage() {
  return (
    <Layout>
      <div className="animate-fade-in">
        <div
          className="rounded-2xl p-8 sm:p-10 mb-8 text-white"
          style={{ background: "linear-gradient(135deg, #1E2A3E 0%, #2C3E50 100%)" }}
        >
          <div className="inline-flex items-center gap-2 bg-white/10 rounded-full px-4 py-1.5 text-sm mb-4">
            <Icon name="Star" size={14} />
            Вдохновляющие истории
          </div>
          <h1 className="text-3xl sm:text-4xl font-extrabold mb-2" style={{ fontFamily: "Montserrat, sans-serif" }}>
            ВЕЛИКИЕ ИНВАЛИДЫ ПЛАНЕТЫ
          </h1>
          <p className="text-blue-100 max-w-2xl">
            Люди, преодолевшие ограничения и изменившие мир — своим трудом, талантом и силой духа.
          </p>
        </div>

        <div className="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
          {PEOPLE.map((person, i) => (
            <div key={person.name} className={`voi-card p-5 flex flex-col stagger-${(i % 6) + 1} animate-fade-in`}>
              <div
                className="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl mb-4 mx-auto"
                style={{ background: "var(--brand-light)" }}
              >
                {person.emoji}
              </div>
              <div className="text-center mb-3">
                <h3 className="font-bold text-base mb-0.5" style={{ color: "var(--brand-dark)", fontFamily: "Montserrat, sans-serif" }}>
                  {person.name}
                </h3>
                <div className="text-xs text-gray-400 mb-1">{person.years}</div>
                <span
                  className="inline-block text-xs px-2.5 py-0.5 rounded-full text-white"
                  style={{ background: "var(--brand-mid)" }}
                >
                  {person.field}
                </span>
              </div>
              <p className="text-gray-600 text-sm leading-relaxed text-center flex-1">{person.description}</p>
            </div>
          ))}
        </div>
      </div>
    </Layout>
  );
}
