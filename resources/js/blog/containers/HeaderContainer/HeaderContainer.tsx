import Header from "../../components/Header/Header";
import React, { FC, useEffect } from "react";
import { Inertia } from "@inertiajs/inertia";

export type SiteHeaders = "Header 1" | "Header 2" | "Header 3";

let OPTIONS = {
  root: null,
  rootMargin: "0px",
  threshold: 1.0,
};
let OBSERVER: IntersectionObserver | null = null;

export interface HeaderContainerProps {
  className?: string;
}

const HeaderContainer: FC<HeaderContainerProps> = ({ className = "" }) => {
  const anchorRef = React.useRef<HTMLDivElement>(null);

  const [headerSelected, setHeaderSelected] =
    React.useState<SiteHeaders>("Header 1");

  const [isTopOfPage, setIsTopOfPage] = React.useState(window.pageYOffset < 5);

  const intersectionCallback = (entries: IntersectionObserverEntry[]) => {
    entries.forEach((entry) => {
      setIsTopOfPage(entry.isIntersecting);
    });
  };

  useEffect(() => {
    if (!OBSERVER) {
      OBSERVER = new IntersectionObserver(intersectionCallback, OPTIONS);
      anchorRef.current && OBSERVER.observe(anchorRef.current);
    }
  }, []);

  useEffect(() => {
    Inertia.on('navigate', (event) => {
        if (event.detail.page.url.includes("home-header-style1")) {
            setHeaderSelected("Header 1");
          }
          if (event.detail.page.url.includes("home-header-style2")) {
            setHeaderSelected("Header 2");
          }
          if (event.detail.page.url.includes("home-header-style2-logedin")) {
            setHeaderSelected("Header 3");
          }
    });
}, []);

  const renderHeader = () => {
    switch (headerSelected) {
      case "Header 1":
        return <Header isTopOfPage={isTopOfPage} mainNavStyle={"style1"} />;
      case "Header 2":
        return <Header isTopOfPage={isTopOfPage} mainNavStyle={"style2"} />;
      case "Header 3":
        return (
          <Header isTopOfPage={isTopOfPage} mainNavStyle={"style2Logedin"} />
        );

      default:
        return <Header isTopOfPage={isTopOfPage} mainNavStyle={"style1"} />;
    }
  };

  return (
    <>
      <div ref={anchorRef} className="h-1 absolute invisible"></div>
      {renderHeader()}
    </>
  );
};

export default HeaderContainer;
