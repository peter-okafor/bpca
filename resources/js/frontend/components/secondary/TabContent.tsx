import React, { ReactNode } from 'react';

interface TabContentProps {
  tabContent: ReactNode[];
  selected: number;
}
export const TabContent: React.FC<TabContentProps> = ({
  tabContent,
  selected
}) => {
  return (
    <div className='w-full px-10'>
      {
        tabContent && tabContent.map((content, key) => (
          <div
            key={key}
            className={`${selected === key ? 'block' : 'hidden'} w-full`}
          >
            {content}
          </div>
        ))
      }
    </div>
  )
}