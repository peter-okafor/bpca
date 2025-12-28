import React, { ReactNode, useState } from 'react';
import { TabContent, TabHeader } from "../components";


interface TabsProps {
  tabHeader: string[];
  children: ReactNode[];
  className?:string;
}

export const Tabs: React.FC<TabsProps> = ({
  tabHeader,
  children,
  className
}) => {
  const [selected, setSelected] = useState(0);

  return (
    <div className={`w-full bg-white pb-10 pt-2 ${className}`}>
      <TabHeader
        tabHeader={tabHeader} 
        onSelect={(selected) => {
          setSelected(selected)
        }}
        selected={tabHeader && (tabHeader.length > selected - 1) ? tabHeader[selected] : undefined}
      />
      <TabContent tabContent={children} selected={selected} />
    </div>
  );
};
