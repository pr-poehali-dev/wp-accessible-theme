import Layout from "@/components/Layout";
import Icon from "@/components/ui/icon";

const ARTICLES = [
  {
    num: "Статья 1",
    title: "Цели",
    text: "Цель настоящей Конвенции заключается в поощрении, защите и обеспечении полного и равного осуществления всеми инвалидами всех прав человека и основных свобод, а также в поощрении уважения присущего им достоинства.",
  },
  {
    num: "Статья 3",
    title: "Общие принципы",
    text: "Уважение присущего человеку достоинства, его личной самостоятельности, включая свободу делать свой собственный выбор, и независимости. Недискриминация. Полное и эффективное вовлечение и включение в общество.",
  },
  {
    num: "Статья 9",
    title: "Доступность",
    text: "Принятие надлежащих мер для обеспечения инвалидам доступа наравне с другими к физическому окружению, транспорту, информации и связи, включая информационно-коммуникационные технологии и системы.",
  },
  {
    num: "Статья 19",
    title: "Самостоятельный образ жизни",
    text: "Инвалиды имеют право жить в обществе, располагают равными с другими людьми возможностями. Государства-участники принимают эффективные и надлежащие меры для того, чтобы инвалиды могли пользоваться этим правом в полной мере.",
  },
  {
    num: "Статья 24",
    title: "Образование",
    text: "Инвалиды имеют право на образование. В целях реализации этого права без дискриминации и на основе равенства возможностей государства-участники обеспечивают инклюзивное образование на всех уровнях.",
  },
  {
    num: "Статья 27",
    title: "Труд и занятость",
    text: "Инвалиды имеют право на труд наравне с другими; это включает право на получение возможности зарабатывать себе на жизнь трудом, который инвалид свободно выбирает или на который он свободно соглашается.",
  },
];

export default function ConventionPage() {
  return (
    <Layout>
      <div className="animate-fade-in">
        <div
          className="rounded-2xl p-8 sm:p-10 mb-8 text-white"
          style={{ background: "linear-gradient(135deg, #1E2A3E 0%, #2C3E50 100%)" }}
        >
          <div className="inline-flex items-center gap-2 bg-white/10 rounded-full px-4 py-1.5 text-sm mb-4">
            <Icon name="Globe" size={14} />
            Международный документ
          </div>
          <h1 className="text-3xl sm:text-4xl font-extrabold mb-2" style={{ fontFamily: "Montserrat, sans-serif" }}>
            КОНВЕНЦИЯ ООН О ПРАВАХ ИНВАЛИДОВ
          </h1>
          <p className="text-blue-100 max-w-2xl">
            Принята резолюцией 61/106 Генеральной Ассамблеи от 13 декабря 2006 года.
            Россия ратифицировала Конвенцию 25 сентября 2012 года.
          </p>
        </div>

        {/* Введение */}
        <div className="voi-card p-6 mb-6 animate-fade-in stagger-1">
          <span className="section-line"></span>
          <h2 className="text-xl font-bold mb-3" style={{ color: "var(--brand-dark)", fontFamily: "Montserrat, sans-serif" }}>
            О документе
          </h2>
          <p className="text-gray-600 leading-relaxed mb-4">
            Конвенция ООН о правах инвалидов — международный правовой документ, определяющий права
            людей с ограниченными возможностями здоровья и обязательства государств по обеспечению
            и защите этих прав.
          </p>
          <p className="text-gray-600 leading-relaxed">
            Конвенция состоит из 50 статей и охватывает такие сферы, как доступность, право на жизнь,
            свободу от пыток, свободу выражения мнений, право на образование, здоровье, труд,
            участие в политической и культурной жизни.
          </p>
          <a
            href="https://www.un.org/ru/documents/decl_conv/conventions/disability.shtml"
            target="_blank"
            rel="noopener noreferrer"
            className="inline-flex items-center gap-2 mt-4 text-sm font-semibold px-4 py-2 rounded-lg text-white transition hover:opacity-90"
            style={{ background: "var(--brand-mid)" }}
          >
            <Icon name="ExternalLink" size={14} />
            Полный текст на сайте ООН
          </a>
        </div>

        {/* Ключевые статьи */}
        <h2 className="text-xl font-bold mb-4" style={{ color: "var(--brand-dark)", fontFamily: "Montserrat, sans-serif" }}>
          Ключевые статьи
        </h2>
        <div className="grid sm:grid-cols-2 gap-4">
          {ARTICLES.map((art, i) => (
            <div key={art.num} className={`voi-card p-5 stagger-${(i % 6) + 1} animate-fade-in`}>
              <div className="flex items-center gap-3 mb-3">
                <span
                  className="text-xs font-bold px-2.5 py-1 rounded-full text-white"
                  style={{ background: "var(--brand-mid)" }}
                >
                  {art.num}
                </span>
                <h3 className="font-bold" style={{ color: "var(--brand-dark)", fontFamily: "Montserrat, sans-serif" }}>
                  {art.title}
                </h3>
              </div>
              <p className="text-gray-600 text-sm leading-relaxed">{art.text}</p>
            </div>
          ))}
        </div>

        {/* Дополнительно */}
        <div
          className="mt-6 rounded-xl p-6 text-white animate-fade-in"
          style={{ background: "var(--brand-dark)" }}
        >
          <div className="flex items-start gap-4">
            <Icon name="Info" size={24} className="flex-shrink-0 mt-0.5" />
            <div>
              <h3 className="font-bold mb-2" style={{ fontFamily: "Montserrat, sans-serif" }}>
                Значение Конвенции для России
              </h3>
              <p className="text-blue-100 text-sm leading-relaxed">
                Ратификация Конвенции обязывает Российскую Федерацию приводить национальное
                законодательство в соответствие с её положениями и периодически отчитываться
                перед Комитетом ООН по правам инвалидов о принятых мерах.
              </p>
            </div>
          </div>
        </div>
      </div>
    </Layout>
  );
}
