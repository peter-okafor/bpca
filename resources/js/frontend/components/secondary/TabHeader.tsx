import React from 'react';

interface TabHeaderProps {
    tabHeader: string[];
    selected?: string;
    onSelect: (selectedKey: number) => void
}

export const TabHeader: React.FC<TabHeaderProps> = ({
    tabHeader,
    selected,
    onSelect
}) => {
    return (
        <ul className='flex flex-row border-b border-gray-300 px-10'>
            {
                tabHeader && tabHeader.map((header, key) => (
                    <li
                        key={key}
                        className={`
                            ${(selected === header || (selected === undefined && key === 0)) ?
                                'border-[#F62F56]' :
                                'text-gray-300 border-transparent'
                            } border-b-2 font-medium mr-6 cursor-pointer py-3 text-sm
                        `}
                        onClick={e => {
                            e.preventDefault()
                            e.stopPropagation()
                            onSelect(key)
                        }}
                    >
                        <a
                            href='#'
                        >
                            {header}
                        </a>
                    </li>
                ))
            }
        </ul>
    )
}