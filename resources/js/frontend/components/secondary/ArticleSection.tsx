import React from 'react';

interface ArticleSectionProps {
  /**
   * Article title
   */
  title: string;
  /**
   * children
   */
  children: JSX.Element;
  className?: string;
}

export const ArticleSection: React.FC<ArticleSectionProps> = ({
  title,
  children,
  className
}) => {
  return (
    <div className={`w-full rounded-md bg-pest-aliceblue px-10 pt-7 pb-5 ${className}`}>
      <h2 className='w-full text-center font-bold text-xl mb-5'>{title}</h2>
      <div>
        {children}
      </div>
    </div>
  );
}