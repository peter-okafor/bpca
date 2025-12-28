import React, { FC, MutableRefObject, useEffect, useRef } from "react";
import Tag from "../../components/Tag/Tag";
import { SinglePageType } from "./PageSingle";
import SingleAuthor from "./SingleAuthor";
import SingleCommentForm from "./SingleCommentForm";
import SingleCommentLists from "./SingleCommentLists";
import parse from 'html-react-parser';

export interface SingleContentProps {
  data: SinglePageType;
}

const SingleContent: FC<SingleContentProps> = ({ data }) => {
  const { tags, author, commentCount, comments, content, id } = data;
  const commentRef = useRef<HTMLDivElement>(null);
  //

  useEffect(() => {
    if (window.document.URL.includes("#comment")) {
        setTimeout(() => {
          if (commentRef.current) {
            commentRef.current.scrollIntoView();
          }
        }, 500);
    }
  }, []);

  return (
    <div className="nc-SingleContent space-y-10">
      {/* ENTRY CONTENT */}
      <div
        id="single-entry-content"
        className="prose lg:prose-lg !max-w-screen-md mx-auto dark:prose-invert"
      >
        {/* IF YOUR DATA IS JSON, YOU CAN USE render with html-react-parser (https://www.npmjs.com/package/html-react-parser) */}
        {parse(content as string)}
      </div>

      {/* TAGS */}
      <div className="max-w-screen-md mx-auto flex flex-wrap">
        {tags.map((item) => (
          <Tag hideCount key={item?.id} tag={item} className="mr-2 mb-2" />
        ))}
      </div>

      {/* AUTHOR */}
      <div className="max-w-screen-md mx-auto border-b border-t border-neutral-100 dark:border-neutral-700"></div>
      <div className="max-w-screen-md mx-auto ">
        <SingleAuthor author={author} />
      </div>

      {/* COMMENT FORM */}
      <div
        id="comment"
        ref={commentRef}
        className="max-w-screen-md mx-auto pt-5"
      >
        <h3 className="text-xl font-semibold text-neutral-800 dark:text-neutral-200">
          Responses ({commentCount})
        </h3>
        <SingleCommentForm
          postId={id as number}
          onClickSubmit={(id) => console.log(id)}
          onClickCancel={(id) => console.log(id)}
        />
      </div>

      {/* COMMENTS LIST */}
      <div className="max-w-screen-md mx-auto">
        <SingleCommentLists comments={comments} postId={id as number} />
      </div>
    </div>
  );
};

export default SingleContent;
