import { useEffect } from "react";
// import { RouterProps, withRouter } from "react-router-dom";

export interface ScrollToTopProps {
  history: ["history"];
}

const ScrollToTop: React.FC<ScrollToTopProps> = ({ history }) => {
//   useEffect(() => {
//     const unlisten = history.listen(() => {
//       window.scrollTo(0, 0);
//     });
//     return () => {
//       unlisten();
//     };
//   }, []);

  return null;
};

export default (ScrollToTop);
