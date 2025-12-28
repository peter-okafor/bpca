import React from 'react';
import { WidgetHeading } from '../primary/WidgetHeading';

interface AtoZArticleSectionProps {
  /**
   * Article title
   */
  title?: string;
  titleColor?: 'white'|'black';
  /**
   * children
   */
  children: JSX.Element;
  className?: string;
}

export const AtoZArticleSection: React.FC<AtoZArticleSectionProps> = ({
  title = '',
  titleColor = 'white',
  children,
  className
}) => {
  return (
    <div className={`w-full rounded-md bg-white px-7 pt-7 pb-5 ${className}`}>
        {title && (
            <WidgetHeading color={titleColor}>{title}</WidgetHeading>
        )}
        <div>
            {children}
        </div>
    </div>
  );
}