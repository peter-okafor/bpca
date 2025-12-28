import { isLatLngLiteral } from '@googlemaps/typescript-guards';
import { createCustomEqual, deepEqual, TypeEqualityComparator } from 'fast-equals';
import React, { FC, ReactNode } from 'react';


interface MapProps extends google.maps.MapOptions {
    className?: string;
    children?: ReactNode;
    onClick?: (e: google.maps.MapMouseEvent) => void;
    onIdle?: (map: google.maps.Map) => void;
}


export const Map: FC<MapProps> = ({
    className,
    onClick,
    onIdle,
    children,
    ...options
}) => {
    const ref = React.useRef<HTMLDivElement>(null);
    const [map, setMap] = React.useState<google.maps.Map>();

    const areObjectsEqual = (
        a: any,
        b: any,
    ) => {
        if (
            isLatLngLiteral(a) ||
            a instanceof google.maps.LatLng ||
            isLatLngLiteral(b) ||
            b instanceof google.maps.LatLng
        ) {
            return new google.maps.LatLng(a).equals(new google.maps.LatLng(b));
        }

        // TODO extend to other types

        // use fast-equals for other objects
        return deepEqual(a, b);
    };

    const deepCompareEqualsForMaps = createCustomEqual(() => ({
        areObjectsEqual
    }));

    function useDeepCompareMemoize(value: any) {
        const ref = React.useRef();

        if (!deepCompareEqualsForMaps(value, ref.current)) {
            ref.current = value;
        }

        return ref.current;
    }

    function useDeepCompareEffectForMaps(
        callback: React.EffectCallback,
        dependencies: any[]
    ) {
        React.useEffect(callback, dependencies.map(useDeepCompareMemoize));
    }

    useDeepCompareEffectForMaps(() => {
        if (map) {
            map.setOptions(options);
        }
    }, [map, options]);

    React.useEffect(() => {
        if (ref.current && !map) {
            setMap(new window.google.maps.Map(ref.current, {
                center: {lat: 6.5244, lng: 3.3792}
            }));
        }
    }, [ref, map]);

    React.useEffect(() => {
        if (map) {
            ["click", "idle"].forEach((eventName) =>
                google.maps.event.clearListeners(map, eventName)
            );

            if (onClick) {
                map.addListener("click", onClick);
            }

            if (onIdle) {
                map.addListener("idle", () => onIdle(map));
            }
        }
    }, [map, onClick, onIdle]);


    return (
        <>
            <div ref={ref} className={className} />
            {React.Children.map(children, (child) => {
                if (React.isValidElement(child)) {
                    // set the map prop on the child component
                    return React.cloneElement(child as React.ReactElement<any>, { map });
                }
            })}
        </>
    )
}
