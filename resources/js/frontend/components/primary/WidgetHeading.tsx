import { FC, HTMLAttributes } from "react";

interface WidgetHeadingProps extends HTMLAttributes<HTMLHeadingElement> {
    color?: 'white'|'black';
}

export const WidgetHeading: FC<WidgetHeadingProps> = ({
    color = 'white',
    className = '',
    ...props
}) => (
    <h3 className={`${className} ${color === 'white' ? 'text-white' : 'text-black'} w-full text-left font-semibold text-2xl mb-7`} {...props}/>
)