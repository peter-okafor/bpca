import { FC, HTMLAttributes } from "react";

interface AtoZAlphabetProps extends HTMLAttributes<HTMLSpanElement> {
    children: string;
    className?: string;
    selected?: boolean;
}

export const AtoZAlphabet: FC<AtoZAlphabetProps> = ({
    children,
    className = '',
    selected,
    ...props
}) => (
    <span className={`text-base text-white cursor-pointer mr-2 ${selected ? 'bg-white text-black' : ''} ${className}`} {...props}>
        {children}
    </span>
)